<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PersonalTrainer;

class TrainerViewController extends Controller
{
    public function index()
    {
        $trainers = PersonalTrainer::withCount('orders')->get();

        return view('superadmin.trainers', compact('trainers'));
    }
}
