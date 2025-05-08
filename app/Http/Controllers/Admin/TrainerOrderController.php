<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalTrainerOrder;

class TrainerOrderController extends Controller
{
    public function index()
    {
        $orders = PersonalTrainerOrder::with(['user', 'trainer'])->latest()->get();
        return view('admin.trainer.orders', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = PersonalTrainerOrder::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function destroy($id)
    {
        PersonalTrainerOrder::findOrFail($id)->delete();
        return back()->with('success', 'Pesanan berhasil dihapus.');
    }



}
