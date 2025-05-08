<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function create()
    {
        $types = MembershipType::all(); // ambil semua jenis membership
        
        // Cek apakah user sudah memiliki membership aktif
        $active_membership = Membership::where('user_id', Auth::id())
                                    ->where('status', 'active')
                                    ->where('end_date', '>=', Carbon::now())
                                    ->with('type')
                                    ->first();
        
        return view('user.member', compact('types', 'active_membership')); // arahkan ke view member.blade.php dengan data active_membership
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_type' => 'required|exists:membership_types,id',
        ]);

        // Ambil data membership_type dari DB
        $type = MembershipType::findOrFail($request->membership_type);

        // Hitung tanggal mulai dan berakhir dari durasi membership
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths($type->duration_in_months);

        // Simpan membership baru
        Membership::create([
            'user_id' => $request->user_id,
            'membership_type' => $type->id,
            'status' => 'active',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'payment_status' => 'unpaid',
            'price' => $type->price,
        ]);

       
        User::where('id', $request->user_id)->update([
            'is_member' => 1,
        ]);

        return redirect()->back()->with('success', 'Pendaftaran membership berhasil!');
    }
    
    // Method untuk memilih paket (baru)
    public function choosePlan($typeId)
    {
        // Cek apakah user sudah memiliki membership aktif
        $hasActiveMembership = Membership::where('user_id', Auth::id())
                                    ->where('status', 'active')
                                    ->where('end_date', '>=', Carbon::now())
                                    ->exists();
        
        if ($hasActiveMembership) {
            return redirect()->back()->with('error', 'Anda sudah memiliki membership aktif.');
        }
        
        // Jika tidak ada membership aktif, arahkan ke halaman konfirmasi/pembayaran
        $type = MembershipType::findOrFail($typeId);
        return view('user.confirm_membership', compact('type'));
    }
}