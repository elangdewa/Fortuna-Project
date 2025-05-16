<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ClassRegistration;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        try {
            $orderId = 'ORDER-' . uniqid();

            // Validate membership_id exists
            if (!$request->membership_id) {
                throw new \Exception('Membership ID is required');
            }

            $payment = Payment::create([
                'user_id' => Auth::id(),
                'transaction_id' => $orderId,
                'payment_status' => 'pending',
                'type' => 'membership',
                'membership_id' => $request->membership_id,
                'amount' => $request->amount ?? 150000,
            ]);

            Log::info('Payment created', ['payment' => $payment->toArray()]);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int)$payment->amount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '',
                ],
                'callbacks' => [
                    'finish' => route('payment.finish'),
                    'error' => route('payment.error'),
                    'cancel' => route('payment.cancel')
                ]
            ];

            Log::info('Creating snap token with params', ['params' => $params]);

            $snapToken = Snap::getSnapToken($params);

            if (!$snapToken) {
                throw new \Exception('Failed to generate Snap Token');
            }

            Log::info('Snap token generated', ['token' => $snapToken]);

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            Log::error('Payment Creation Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['error' => 'Gagal mendapatkan token pembayaran: ' . $e->getMessage()], 500);
        }
    }
}
