<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\ClassSchedule;
use App\Models\ClassRegistration;
use App\Models\PersonalTrainer;
use App\Models\PersonalTrainerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Carbon\Carbon;
use Midtrans\Transaction;

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
            'is_production' => Config::$isProduction
        ]);
    }

    public function createMembershipPayment(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'membership_type' => 'required|exists:membership_types,id',
            ]);

            $user = Auth::user();
            $type = MembershipType::findOrFail($request->membership_type);

            // Create membership
            $membership = new Membership();
            $membership->user_id = $user->id;
            $membership->membership_type = $type->id;
            $membership->price = $type->price;
            $membership->status = 'inactive';
            $membership->payment_status = 'unpaid';
            $membership->save();

            // Create payment
            $transactionId = 'ORDER-' . uniqid();
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->membership_id = $membership->id;
            $payment->type = 'membership';
            $payment->payment_method = 'midtrans';
            $payment->payment_status = 'pending';
            $payment->transaction_id = $transactionId;
            $payment->amount = $type->price;
            $payment->reference_id = $membership->id;
            $payment->save();

            // Setup Midtrans
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
                'order_id' => $transactionId
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createTrainerPayment(Request $request)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'trainer_id' => 'required|exists:personal_trainers,id',
            'order_date' => 'required|date|after_or_equal:today',
        ]);

        $user = Auth::user();
        $trainer = PersonalTrainer::findOrFail($request->trainer_id);


        $order = PersonalTrainerOrder::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'order_date' => $request->order_date,
            'sessions' => 10, // Fixed 10 sessions
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'total_price' => 200000, // Fixed price
            'expires_at' => Carbon::parse($request->order_date)->addMonths(2) // Valid for 2 months
        ]);

        // Create payment record
        $transactionId = 'TRAINER-' . uniqid();
        $payment = Payment::create([
            'user_id' => $user->id,
            'type' => 'trainer_order',
            'payment_method' => 'midtrans',
            'payment_status' => 'pending',
            'transaction_id' => $transactionId,
            'amount' => 200000,
            'reference_id' => $order->id
        ]);

        // Setup Midtrans payment
        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => 2500,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [[
                'id' => 'PT-10',
                'price' => 200000,
                'quantity' => 1,
                'name' => "Paket 10 Sesi PT with {$trainer->name}"
            ]]
        ];

        $snapToken = Snap::getSnapToken($params);

        DB::commit();

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $transactionId
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Trainer payment creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat pembayaran: ' . $e->getMessage()
        ], 500);
    }
}

   public function createClassRegistrationPayment(Request $request)
{
    DB::beginTransaction();
    try {
        // Log awal request
        Log::info('Starting class registration', [
            'schedule_id' => $request->schedule_id,
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'schedule_id' => 'required|exists:class_schedules,id'
        ]);

        $user = Auth::user();
        $schedule = ClassSchedule::findOrFail($request->schedule_id);

        // Log data schedule
        Log::info('Schedule found', [
            'schedule' => $schedule->toArray()
        ]);

        // Check if class is full
        if ($schedule->isFull()) {
            throw new \Exception('Kelas sudah penuh');
        }

        // Create registration dengan try-catch terpisah
        try {
            DB::statement("
                INSERT INTO class_registrations
                (user_id, class_id, schedule_id, registered_at)
                VALUES (?, ?, ?, NOW())",
                [$user->id, $schedule->class_id, $schedule->id]
            );

            $registration = DB::select("
                SELECT * FROM class_registrations
                WHERE user_id = ? AND schedule_id = ?
                ORDER BY registered_at DESC LIMIT 1",
                [$user->id, $schedule->id]
            );

            if (empty($registration)) {
                throw new \Exception('Gagal membuat registrasi kelas');
            }

            $registration = $registration[0];

            // Log registration berhasil
            Log::info('Registration created', [
                'registration_id' => $registration->id
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create registration', [
                'error' => $e->getMessage(),
                'sql_error' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
            ]);
            throw new \Exception('Gagal membuat registrasi: ' . $e->getMessage());
        }

        // Create payment dengan try-catch terpisah
        try {
            $transactionId = 'CLASS-' . uniqid();
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->type = 'class_registration';
            $payment->payment_method = 'midtrans';
            $payment->payment_status = 'pending';
            $payment->transaction_id = $transactionId;
            $payment->amount = $schedule->price;
            $payment->reference_id = $registration->id;
            $payment->save();

            // Log payment berhasil
            Log::info('Payment record created', [
                'payment_id' => $payment->id,
                'transaction_id' => $transactionId
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create payment record', [
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Gagal membuat record pembayaran');
        }

        // Setup Midtrans dengan try-catch terpisah
        try {
            $params = [
                'transaction_details' => [
                    'order_id' => $transactionId,
                    'gross_amount' => (int) $schedule->price,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => [[
                    'id' => $schedule->id,
                    'price' => (int) $schedule->price,
                    'quantity' => 1,
                    'name' => $schedule->fitnessClass->name . ' - ' .
                             $schedule->day_of_week . ' ' .
                             $schedule->start_time
                ]]
            ];

            // Log Midtrans params
            Log::info('Midtrans params', [
                'params' => $params
            ]);

            $snapToken = Snap::getSnapToken($params);

            // Log snap token berhasil
            Log::info('Snap token generated', [
                'token' => $snapToken
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get snap token', [
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Gagal mendapatkan token pembayaran');
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $transactionId
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Class registration failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Gagal mendaftar kelas: ' . $e->getMessage()
        ], 500);
    }
}

    public function handleCallback(Request $request)
    {
        try {
            Log::info('Callback received', [
                'data' => $request->all()
            ]);

            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            $payment = Payment::where('transaction_id', $orderId)->first();
            if (!$payment) {
                throw new \Exception("Payment tidak ditemukan: $orderId");
            }

            DB::beginTransaction();

            // Update payment status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $payment->payment_status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $this->updatePaymentAndRelated($payment);
                }
            }
            else if ($transactionStatus == 'settlement') {
                $this->updatePaymentAndRelated($payment);
            }
            else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $payment->payment_status = 'failed';
            }
            else if ($transactionStatus == 'pending') {
                $payment->payment_status = 'pending';
            }

            $payment->save();
            DB::commit();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Callback failed', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function updatePaymentAndRelated($payment)
    {
       $payment->payment_status = 'paid';
    $payment->payment_time = now();
    $payment->save();

    if ($payment->type === 'class_registration') {
        DB::statement("
            UPDATE class_registrations
            SET status = 'active',
            payment_status = 'paid'
            WHERE id = ?",
            [$payment->reference_id]
        );
    }

        // Handle membership payment
        if ($payment->type === 'membership' && $payment->membership_id) {
            $membership = Membership::find($payment->membership_id);
            if ($membership) {
                $type = MembershipType::find($membership->membership_type);
                $membership->status = 'active';
                $membership->payment_status = 'paid';
                $membership->start_date = now();
                $membership->end_date = now()->addMonths($type->duration_in_months);
                $membership->save();
            }
        }
        // Handle class registration payment
        else if ($payment->type === 'class_registration') {
            $registration = ClassRegistration::find($payment->reference_id);
            if ($registration) {
                $registration->status = 'active';
                $registration->payment_status = 'paid';
                $registration->save();
            }
        }
    }

    public function checkPaymentStatus($orderId)
    {
        $payment = Payment::where('transaction_id', $orderId)->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'payment' => $payment,
            'status' => $payment->payment_status,
            'created_at' => $payment->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $payment->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function paymentSuccess(Request $request)
{
    $orderId = $request->query('order_id'); // Pastikan order_id dikirim

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false;

    $status = Transaction::status($orderId);

    // Pastikan status adalah object
    if (is_array($status)) {
        $status = (object) $status;
    }

    if (isset($status->transaction_status) && $status->transaction_status === 'settlement') {
        $payment = Payment::where('transaction_id', $orderId)->first();

        if ($payment && $payment->payment_status !== 'paid') {
            $payment->payment_status = 'paid';
            $payment->save();

            $membership = Membership::where('user_id', $payment->user_id)->first();
            if ($membership) {
                $membership->status = 'active';
                $membership->start_date = now();
                $membership->end_date = now()->addMonths($membership->duration ?? 1);
                $membership->payment_status = 'paid';
                $membership->save();
            }
        }

        return redirect('/dashboard')->with('success', 'Membership berhasil diaktifkan!');
    }

    return redirect('/dashboard')->with('error', 'Pembayaran belum selesai.');
}

public function verifyPayment(Request $request)
{
    $orderId = $request->input('order_id');

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false;

    $status = Transaction::status($orderId);

    if (is_array($status)) {
        $status = (object) $status;
    }

    if (isset($status->transaction_status) && $status->transaction_status === 'settlement') {
        $payment = Payment::where('transaction_id', $orderId)->first();

        if ($payment && $payment->payment_status !== 'paid') {
            $payment->payment_status = 'paid';
            $payment->save();

            $membership = Membership::where('user_id', $payment->user_id)->first();
            if ($membership) {
                $membership->status = 'active';
                $membership->start_date = now();
                $membership->end_date = now()->addMonths($membership->duration ?? 1);
                $membership->payment_status = 'paid';
                $membership->save();
            }
        }

        return back()->with('success', 'Membership sudah aktif!');
    }

    return back()->with('error', 'Pembayaran belum selesai.');
}

}
