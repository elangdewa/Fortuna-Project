<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTrainerOrder;
use App\Models\PersonalTrainer;
use Illuminate\Support\Facades\Auth;

class UserTrainerOrderController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'trainer_id' => 'required|exists:personal_trainers,id',
        ]);

        // Membuat pesanan baru
        $order = new PersonalTrainerOrder();
        $order->user_id = Auth::id(); // ID user yang sedang login
        $order->trainer_id = $request->trainer_id;
        $order->order_date = now(); // Tanggal pesanan
        $order->notes = 'Pesanan baru'; // Kamu bisa sesuaikan jika ada catatan
        $order->status = 'pending'; // Status default "pending"
        $order->save();

        return redirect()->back()->with('success', 'Pesanan personal trainer berhasil dibuat!');
    }
}