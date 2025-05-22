<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membership;
use App\Models\PersonalTrainer;
use App\Models\FitnessClass;
use App\Models\MembershipType;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMembers = User::where('is_member', true)->count();
        $totalTrainers = PersonalTrainer::count();
        $activeMemberships = Membership::where('status', 'active')->count();
        $totalFitnessClasses = FitnessClass::count();
        $totalPackages = MembershipType::count();

      
        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalMembers',
            'totalTrainers',
            'activeMemberships',
            'totalFitnessClasses',
            'totalPackages',

        ));
    }
}
