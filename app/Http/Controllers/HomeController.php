<?php

namespace App\Http\Controllers;
use App\Models\MembershipType;
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;
use App\Http\Controllers\MembershipController;
use App\Models\FitnessPackage;
use App\Models\ClassSchedule; // atau nama model untuk jadwal kelas
use App\Models\FitnessClass;
use App\Models\PersonalTrainerOrder;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

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
    $memberships = Membership::all();
    $schedules = ClassSchedule::with(['fitnessClass', 'registrations'])->get();
    $trainers = PersonalTrainer::all();

    return view('user.home', compact('memberships', 'schedules', 'trainers'));
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
