<?php


namespace App\Http\Controllers;

use App\Models\PersonalTrainer; 
use Illuminate\Http\Request;

class UserTrainerController extends Controller
{
    public function index()
    {
        $trainers = PersonalTrainer::all();
        return view('user.trainers', compact('trainers'));
    }
}