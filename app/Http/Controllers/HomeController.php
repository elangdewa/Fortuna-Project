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
      $memberships = MembershipType::select('name', 'price', 'duration_in_months')
        ->orderBy('price')
        ->take(3)
        ->get();
    $types = MembershipType::all();
    $schedules = ClassSchedule::with(['fitnessClass', 'registrations'])->get();
    $trainers = PersonalTrainer::all();

    return view('user.home', compact('memberships', 'schedules', 'trainers','types'));
}
    public function fitness()
{
    return view('user.fitness');
}

public function member()
{
    $user = Auth::user();
    $types = MembershipType::all();

    $active_membership = Membership::where('user_id', $user->id)
        ->where('status', 'active')
        ->where('end_date', '>=', now())
        ->with('type')
        ->first();

    $latest_membership = Membership::where('user_id', $user->id)
        ->with('type')
        ->latest('end_date')
        ->first();

    $membership_history = Membership::where('user_id', $user->id)
        ->with('type')
        ->orderByDesc('start_date')
        ->get();

    return view('user.member', compact(
        'types',
        'user',
        'active_membership',
        'latest_membership',
        'membership_history'
    ));
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
