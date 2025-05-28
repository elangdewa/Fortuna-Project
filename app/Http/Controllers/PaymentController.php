<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Membership;
use App\Models\ClassRegistration;
use App\Models\ClassSchedule;
use App\Models\MembershipType;
use App\Models\PersonalTrainerOrder;
use App\Models\PersonalTrainer;
use App\Models\FitnessClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this line
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        Log::info('Midtrans configured', [
            'server_key' => Config::$serverKey ? 'Set' : 'Not Set',
            'client_key' => Config::$clientKey ? 'Set' : 'Not Set',
            'is_production' => Config::$isProduction,
            'environment' => Config::$isProduction ? 'production' : 'sandbox'
        ]);
    }

    public function createTransaction(Request $request)
    {
        try {
            Log::info('Creating transaction', $request->all());

            $user = Auth::user();
            $orderId = strtoupper($request->type) . '-' . uniqid();

            $validationRules = $this->getValidationRules($request->type);
            $request->validate($validationRules);

            Log::info('Creating transaction', [
                'type' => $request->type,
                'reference_id' => $request->reference_id,
                'amount' => $request->amount
            ]);

            // Ambil detail item berdasarkan tipe transaksi
            $itemDetails = $this->getItemDetails($request->type, $request->reference_id, $request->amount);

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $request->amount,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                ],
            ];

            Log::info('Midtrans params', $params);

            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Simpan data pembayaran ke tabel payments
            $payment = Payment::create([
                'user_id' => $user->id,
                'transaction_id' => $orderId,
                'amount' => $request->amount,
                'payment_method' => 'midtrans',
                'payment_status' => 'pending',
                'type' => $request->type,
                'reference_id' => $request->reference_id,
            ]);

            Log::info('Payment created', ['payment_id' => $payment->id, 'snap_token' => $snapToken]);

            return response()->json([
                'snapToken' => $snapToken,
                'orderId' => $orderId,
                'success' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Payment creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Gagal membuat transaksi: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    private function getValidationRules($type)
    {
        $baseRules = [
            'type' => 'required|string',
            'reference_id' => 'required',
            'amount' => 'required|numeric|min:1'
        ];

        switch ($type) {
            case 'membership':
                return array_merge($baseRules, [
                    'reference_id' => 'required|exists:membership_types,id'
                ]);

            case 'personal_trainer':
                return array_merge($baseRules, [
                    'reference_id' => 'required|exists:personal_trainer_orders,id',
                    'trainer_id' => 'sometimes|exists:personal_trainers,id',
                    'session_date' => 'sometimes|date|after:today',
                    'session_time' => 'sometimes|date_format:H:i'
                ]);

          case 'fitness_class':
case 'class_registration':
    return array_merge($baseRules, [
        'reference_id' => 'required|exists:class_registrations,id',
        'class_schedule_id' => 'sometimes|exists:class_schedules,id', // Tambahan ini
    ]);

            default:
                return $baseRules;
        }
    }

    private function getItemDetails($type, $referenceId, $amount)
    {
        switch ($type) {
            case 'membership':
                $membershipType = MembershipType::findOrFail($referenceId);
                return [[
                    'id' => 'membership-' . $referenceId,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Membership ' . $membershipType->name,
                    'brand' => 'Gym Membership',
                    'category' => 'Membership'
                ]];

            case 'personal_trainer':
                $order = PersonalTrainerOrder::with('trainer')->findOrFail($referenceId);
                return [[
                    'id' => 'trainer-' . $referenceId,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Personal Trainer - ' . $order->trainer->name,
                    'brand' => 'Personal Training',
                    'category' => 'Training'
                ]];

            case 'fitness_class':
            case 'class_registration':
             $classRegistration = ClassRegistration::with('schedule.fitnessClass')->findOrFail($referenceId);
$classSchedule = $classRegistration->schedule;
return [[
    'id' => 'class-' . $referenceId,
    'price' => (int) $amount,
    'quantity' => 1,
    'name' => 'Fitness Class - ' . $classSchedule->fitnessClass->name,
    'brand' => 'Fitness Class',
    'category' => 'Class'
]];

            default:
                throw new \Exception('Tipe transaksi tidak valid: ' . $type);
        }
    }

    public function checkStatus($orderId)
    {
        try {
            Log::info('Manual status check for order', ['order_id' => $orderId]);

            $statusResponse = Transaction::status($orderId);
            $payment = Payment::where('transaction_id', $orderId)->firstOrFail();

            $status = is_object($statusResponse) ? (array) $statusResponse : $statusResponse;

            Log::info('Midtrans status response', [
                'order_id' => $orderId,
                'transaction_status' => $status['transaction_status'] ?? null,
                'payment_type' => $status['payment_type'] ?? null,
                'fraud_status' => $status['fraud_status'] ?? null
            ]);

            $transactionStatus = $status['transaction_status'] ?? '';
            $fraudStatus = $status['fraud_status'] ?? 'accept';

            $updated = $this->updatePaymentStatus($payment, $transactionStatus, $fraudStatus);

            return $this->redirectAfterPayment($payment);

        } catch (\Exception $e) {
            Log::error('Manual status check failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat memeriksa status pembayaran.');
        }
    }

    private function redirectAfterPayment($payment)
    {
        $successMessage = 'Pembayaran berhasil!';
        $errorMessage = 'Pembayaran belum selesai. Silakan coba lagi.';

        switch ($payment->type) {
            case 'membership':
                $route = 'user.member';
                $successMessage = 'Pembayaran berhasil! Anda sekarang menjadi member.';
                break;

            case 'personal_trainer':
                $route = 'user.trainer';
                $successMessage = 'Pembayaran berhasil! Sesi personal trainer Anda telah dikonfirmasi.';
                break;

            case 'fitness_class':
            case 'class_registration':
                $route = 'user.fitness';
                $successMessage = 'Pembayaran berhasil! Anda telah terdaftar dalam kelas fitness.';
                break;

            default:
                $route = 'dashboard';
        }

        if ($payment->payment_status === 'paid') {
            return redirect()->route($route)->with('success', $successMessage);
        }

        return redirect()->route($route)->with('error', $errorMessage);
    }

    private function updatePaymentStatus(Payment $payment, $transactionStatus, $fraudStatus)
    {

        Log::info('Starting payment status update', [
        'payment_id' => $payment->id,
        'type' => $payment->type,
        'transaction_status' => $transactionStatus,
        'fraud_status' => $fraudStatus
    ]);

        $oldStatus = $payment->payment_status;
        $updated = false;

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            if ($fraudStatus == 'accept' || $fraudStatus == '') {
                $payment->payment_status = 'paid';
                $payment->payment_time = now();
                $this->activateService($payment);
                $updated = true;

                Log::info('Payment successful, service activated', ['payment_id' => $payment->id]);
            }
        } elseif ($transactionStatus === 'pending') {
            if ($payment->payment_status !== 'pending') {
                $payment->payment_status = 'pending';
                $updated = true;
            }
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            if ($payment->payment_status !== 'failed') {
                $payment->payment_status = 'failed';
                $updated = true;
            }
        }

        if ($updated) {
            $payment->save();
            Log::info('Payment status updated', [
                'payment_id' => $payment->id,
                'old_status' => $oldStatus,
                'new_status' => $payment->payment_status
            ]);
        }

        return $updated;
    }

    private function activateService(Payment $payment)
    {
        try {
            switch ($payment->type) {
                case 'membership':
                    $this->activateMembership($payment);
                    break;

                case 'personal_trainer':
                    $this->activatePersonalTrainer($payment);
                    break;

                case 'fitness_class':
                case 'class_registration':
                    $this->activateFitnessClass($payment);
                    break;

                default:
                    Log::warning('Unknown payment type for activation', [
                        'payment_id' => $payment->id,
                        'type' => $payment->type
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('Service activation failed', [
                'payment_id' => $payment->id,
                'type' => $payment->type,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function activateMembership(Payment $payment)
    {
        $membershipType = MembershipType::findOrFail($payment->reference_id);

        $membership = Membership::create([
            'user_id' => $payment->user_id,
            'membership_type' => $membershipType->id,
            'price' => $membershipType->price,
            'payment_status' => 'paid',
            'status' => 'active',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths($membershipType->duration_in_months),
        ]);

        $user = $membership->user;
        $user->is_member = 1;
        $user->save();

        Log::info('Membership activated', ['membership_id' => $membership->id]);
    }

 private function activatePersonalTrainer(Payment $payment)
{
    $order = PersonalTrainerOrder::find($payment->reference_id);
    if ($order) {
        $order->payment_status = 'paid';
        $order->status = 'approved';
        $order->save();
        Log::info('Personal trainer order confirmed', ['order_id' => $order->id]);
    } else {
        $order = PersonalTrainerOrder::create([
            'user_id' => $payment->user_id,
            'trainer_id' => $payment->trainer_id ?? null,
            'order_date' => now(),
            'sessions' => 10,
            'price' => $payment->amount,
            'notes' => $payment->notes ?? null,
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);
        Log::info('Personal trainer order created & confirmed', ['order_id' => $order->id]);
    }
}

  private function activateFitnessClass(Payment $payment)
{
    Log::info('Starting fitness class activation', [
        'payment_id' => $payment->id,
        'reference_id' => $payment->reference_id
    ]);

    try {
        DB::beginTransaction();

        $registration = ClassRegistration::find($payment->reference_id);

        if ($registration) {
            // Update registration yang sudah ada
            $registration->payment_status = 'paid';
            $registration->status = 'active';
            $registration->save();

            Log::info('Existing fitness class registration activated', [
                'registration_id' => $registration->id
            ]);
        } else {
            // Buat registration baru jika tidak ada
            $registration = ClassRegistration::create([
                'user_id' => $payment->user_id,
                'class_schedule_id' => $payment->class_schedule_id ?? null,
                'payment_status' => 'paid',
                'status' => 'active',
                'registered_at' => now(),
                'price' => $payment->amount
            ]);

            Log::info('New fitness class registration created', [
                'registration_id' => $registration->id
            ]);
        }

        // Update payment status
        $payment->payment_status = 'paid';
        $payment->payment_time = now();
        $payment->save();

        DB::commit();
        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to activate fitness class', [
            'payment_id' => $payment->id,
            'error' => $e->getMessage()
        ]);
        throw $e;
    }
}

    // Method lainnya tetap sama (checkPaymentStatus, getPendingPayments, dll)
    public function checkPaymentStatus($paymentId)
    {
        try {
        $payment = Payment::where('transaction_id', $paymentId)->firstOrFail();

            if ($payment->payment_status === 'paid') {
                return response()->json([
                    'success' => true,
                    'payment_status' => 'paid',
                    'message' => 'Pembayaran sudah berhasil'
                ]);
            }

            $statusResponse = Transaction::status($payment->transaction_id);
            $status = is_object($statusResponse) ? (array) $statusResponse : $statusResponse;

            $transactionStatus = $status['transaction_status'] ?? '';
            $fraudStatus = $status['fraud_status'] ?? 'accept';

            $updated = $this->updatePaymentStatus($payment, $transactionStatus, $fraudStatus);

            return response()->json([
                'success' => true,
                'payment_status' => $payment->payment_status,
                'transaction_status' => $transactionStatus,
                'updated' => $updated,
                'message' => $this->getStatusMessage($payment->payment_status)
            ]);

        } catch (\Exception $e) {
            Log::error('Payment status check failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Gagal memeriksa status pembayaran'
            ], 500);
        }
    }

    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'paid':
                return 'Pembayaran berhasil! Layanan telah diaktifkan.';
            case 'pending':
                return 'Pembayaran sedang diproses. Silakan tunggu konfirmasi.';
            case 'failed':
                return 'Pembayaran gagal atau dibatalkan.';
            default:
                return 'Status pembayaran: ' . $status;
        }
    }

    public function notificationHandler(Request $request)
{
    try {
        $notif = new \Midtrans\Notification();

        Log::info('Notification received', [
            'order_id' => $notif->order_id,
            'transaction_status' => $notif->transaction_status,
            'type' => $notif->order_id ? explode('-', $notif->order_id)[0] : null
        ]);

        $payment = Payment::where('transaction_id', $notif->order_id)->first();

        if ($payment) {
            Log::info('Payment found', [
                'payment_id' => $payment->id,
                'type' => $payment->type,
                'reference_id' => $payment->reference_id
            ]);

            $this->updatePaymentStatus($payment, $notif->transaction_status, $notif->fraud_status ?? 'accept');

            Log::info('Payment status updated', [
                'new_status' => $payment->payment_status,
                'type' => $payment->type
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Notification handler error', ['error' => $e->getMessage()]);
    }
}
}
