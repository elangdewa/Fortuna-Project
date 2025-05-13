<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalTrainerOrder;
use Illuminate\Http\Request;

class TrainerOrderController extends Controller
{
    public function index()
    {
        $orders = PersonalTrainerOrder::with(['user', 'trainer'])
                    ->orderBy('order_date', 'desc')
                    ->get();

        return view('admin.trainer.orders', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = PersonalTrainerOrder::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $order = PersonalTrainerOrder::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }
}