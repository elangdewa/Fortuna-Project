<?php

namespace App\Http\Controllers;
use App\Models\MembershipType; 
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.home');
    }
    public function fitness()
{
    return view('user.fitness');
}

public function member()
{
    $types = MembershipType::all(); // ambil data jenis membership
    return view('user.member', compact('types'));
}

public function setting()
{
    return view('user.setting');
}

public function trainer()
{
    $trainers = PersonalTrainer::all(); // Ini benar
    return view('user.trainer', compact('trainers'));
}

}
