<?php

namespace App\Http\Controllers;

use App\Models\PersonalTrainer;
use App\Models\PersonalTrainerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTrainerController extends Controller
{
    public function index()
    {
        $trainers = PersonalTrainer::all();
        return view('user.trainers', compact('trainers'));
    }

    public function showTrainerPage()
    {
        $trainers = PersonalTrainer::all();
        $orders = PersonalTrainerOrder::where('user_id', Auth::id()) // Ganti ini
                    ->with('trainer')
                    ->latest()
                    ->get();

        return view('user.trainer', compact('trainers', 'orders'));
    }
}
