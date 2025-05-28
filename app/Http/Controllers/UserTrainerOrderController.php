<?php

namespace App\Http\Controllers;

use App\Models\PersonalTrainerOrder;
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTrainerOrderController extends Controller
{
    public function create()
    {
        $trainers = PersonalTrainer::all();
        return view('user.trainer_orders.create', compact('trainers'));
    }

   public function store(Request $request)
{
    $request->validate([
        'trainer_id' => 'required|exists:personal_trainers,id',
        'notes' => 'nullable|string',
        'order_date' => 'required|date',
    ]);

    $order = PersonalTrainerOrder::create([
        'user_id' => Auth::id(),
        'trainer_id' => $request->trainer_id,
        'notes' => $request->notes,
        'sessions' => 10,
        'order_date' => $request->order_date,
        'status' => 'pending',
        'total_price' => 200000,
        'payment_status' => 'unpaid'
    ]);

    return response()->json(['success' => true, 'order' => $order]);
}

    public function index()
{
    $orders = PersonalTrainerOrder::where('user_id', Auth::id())->with('trainer')->get();
    return view('user.trainer', compact('orders'));
}

public function showTrainerPage()
{
    $trainers = PersonalTrainer::all();
  $orders = PersonalTrainerOrder::where('user_id', Auth::id())
            ->with('trainer')
            ->latest()
            ->get();

    return view('user.trainer', compact('trainers', 'orders'));
}
}
