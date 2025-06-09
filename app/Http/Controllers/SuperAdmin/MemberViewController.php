<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;

class MemberViewController extends Controller
{
   public function index()
    {
        $members = User::where('role', 'member')
                      ->with('membership.type')
                      ->get();
        return view('superadmin.members', compact('members'));
    }
}
