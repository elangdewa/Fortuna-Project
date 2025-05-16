<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Membership;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createMembershipPayment(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi
            $request->validate([
                'membership_type' => 'required|exists:membership_types,id',
            ]);

            $user = Auth::user();
            $type = MembershipType::findOrFail($request->membership_type);

            // Buat membership
            $membership = Membership::create([
                'user_id' => $user->id,
                'membership_type' => $type->id,
                'price' => $type->price,
                'status' => 'inactive',
                'payment_status' => 'unpaid',
            ]);

            // Buat payment
            $transactionId = 'ORDER-' . uniqid();
            $payment = Payment::create([
                'user_id' => $user->id,
                'membership_id' => $membership->id,
                'type' => 'membership',
                'payment_method' => 'midtrans',
                'payment_status' => 'pending',
                'transaction_id' => $transactionId,
                'amount' => $type->price,
                'reference_id' => $membership->id,
            ]);

            // Konfigurasi transaksi Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $transactionId,
                    'gross_amount' => (int) $type->price,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [[
                    'id' => $type->id,
                    'price' => (int) $type->price,
                    'quantity' => 1,
                    'name' => 'Membership ' . $type->name,
                ]],
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $transactionId,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error createMembershipPayment', [
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pembayaran.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function handleCallback(Request $request)
{
    try {
        Log::info('======== PAYMENT CALLBACK STARTED ========');
        Log::info('Request data:', $request->all());

        // Parse notification dari Midtrans
        $notification = new Notification();
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        Log::info('Notification details:', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $notification->payment_type,
            'gross_amount' => $notification->gross_amount
        ]);

        // Cari payment berdasarkan transaction_id (order_id)
        $payment = Payment::where('transaction_id', $orderId)->first();

        if (!$payment) {
            Log::error('Payment not found for order_id: ' . $orderId);
            throw new \Exception('Payment not found');
        }

        Log::info('Current payment status:', [
            'payment_id' => $payment->id,
            'current_status' => $payment->payment_status
        ]);

        DB::beginTransaction();

        // Update payment status berdasarkan notifikasi
        $newStatus = $payment->payment_status;

        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'accept') {
                    $newStatus = 'paid';
                }
                break;
            case 'settlement':
                $newStatus = 'paid';
                break;
            case 'pending':
                $newStatus = 'pending';
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $newStatus = 'failed';
                break;
        }

        // Update payment jika status berubah
        if ($newStatus !== $payment->payment_status) {
            $payment->payment_status = $newStatus;
            $payment->payment_time = ($newStatus === 'paid') ? now() : null;
            $payment->save();

            Log::info('Payment updated:', [
                'payment_id' => $payment->id,
                'old_status' => $payment->getOriginal('payment_status'),
                'new_status' => $newStatus,
                'updated_at' => $payment->updated_at
            ]);
        } else {
            Log::info('No payment status change needed');
        }

        DB::commit();

        Log::info('======== PAYMENT CALLBACK COMPLETED ========');
        return response()->json(['status' => 'success']);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Callback error:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
// Tambahkan method baru untuk update payment dan membership
private function updatePaymentAndMembership($payment)
{
    try {
        // Update payment
        $payment->payment_status = 'paid';
        $payment->payment_time = now();
        $payment->save();

        // Update membership
        if ($payment->membership_id) {
            $membership = Membership::findOrFail($payment->membership_id);
            $type = MembershipType::findOrFail($membership->membership_type);

            $membership->status = 'active';
            $membership->payment_status = 'paid';
            $membership->start_date = now();
            $membership->end_date = now()->addMonths($type->duration_in_months);
            $membership->save();

            Log::info('Membership activated', [
                'membership_id' => $membership->id,
                'payment_id' => $payment->id
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Error updating payment and membership', [
            'error' => $e->getMessage(),
            'payment_id' => $payment->id
        ]);
        throw $e;
    }
}
}
