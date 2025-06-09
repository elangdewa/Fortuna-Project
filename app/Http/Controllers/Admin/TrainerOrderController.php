<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalTrainerOrder;
use Illuminate\Http\Request;

class TrainerOrderController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $orders = PersonalTrainerOrder::with(['user', 'trainer'])
        ->when($search, function($query) use ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('trainer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->orderBy('order_date', 'desc')
        ->paginate(10);

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
