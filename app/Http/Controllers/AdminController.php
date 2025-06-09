<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FitnessClass;
use App\Models\PersonalTrainer;
use App\Models\MembershipType;
use App\Models\User;
use App\Models\PersonalTrainerOrder;

class AdminController extends Controller
{
     public function index()
    {

    $recentMembers = User::where('role', 'member')
        ->with('membershipType')
        ->latest()
        ->take(5)
        ->get();

    return view('admin.admin', [
        'totalMembers' => User::where('role', 'member')->count(),
        'totalTrainers' => PersonalTrainer::count(),
        'totalFitnessClasses' => FitnessClass::count(),
        'totalPackages' => MembershipType::count(),
        'recentMembers' => $recentMembers
    ]);
    }

    public function members()
    {
        return view('admin.members.view');
    }

    // Create Member
    public function createMember()
    {
        return view('admin.members.create');
    }

    // Paket Member
    public function paket()
    {
        return view('admin.paketmember.paket');
    }

    // Kelas Fitness
    public function kelas()
    {
        return view('admin.fitness.fitness');
    }


    public function coach()
    {
        return view('admin.trainer.trainer');
    }
}
