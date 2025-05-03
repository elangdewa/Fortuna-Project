<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function index()
    {
        //
    }
public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'membership_type' => 'required|exists:membership_types,id',
    ]);

    $startDate = Carbon::now();
    $endDate = $startDate->copy()->addDays(30); // durasi 30 hari, bisa diatur

    // Simpan ke tabel memberships
    Membership::create([
        'user_id' => $request->user_id,
        'membership_type' => $request->membership_type,
        'status' => 'active',
        'start_date' => $startDate,
        'end_date' => $endDate,
        'payment_status' => 'pending', 
    ]);

    // Update is_member pada tabel users
    User::where('id', $request->user_id)->update([
        'is_member' => 1,
    ]);

    return redirect()->back()->with('success', 'Pendaftaran membership berhasil!');
}
}