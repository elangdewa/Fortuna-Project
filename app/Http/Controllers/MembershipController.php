<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    /**
     * Menyimpan data membership baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_type' => 'required|exists:membership_types,id',
        ]);

        // Cek apakah user sudah punya membership aktif
        $hasActiveMembership = Membership::where('user_id', $request->user_id)
            ->where('status', 'active')
            ->where('end_date', '>=', Carbon::now())
            ->exists();

        if ($hasActiveMembership) {
            return redirect()->back()->with('error', 'Anda sudah memiliki membership aktif.');
        }

        // Simpan data Membership sementara (status: pending, payment_status: pending)
        $type = MembershipType::findOrFail($request->membership_type);
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths($type->duration_in_months);

        $membership = Membership::create([
            'user_id' => $request->user_id,
            'membership_type' => $type->id,
            'status' => 'pending',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'payment_status' => 'pending',
            'price' => $type->price,
        ]);

        // Redirect ke payment
        return redirect()->route('membership.payment', ['membershipId' => $membership->id]);
    }

    /**
     * Menampilkan riwayat membership user
     */
    public function history()
    {
        $memberships = Membership::where('user_id', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->with('type')
                                ->get();

        return view('user.membership_history', compact('memberships'));
    }

    /**
     * Menampilkan detail membership
     */
    public function show($id)
    {
        $membership = Membership::where('id', $id)
                              ->where('user_id', Auth::id())
                              ->with('type', 'user')
                              ->firstOrFail();

        return view('user.membership_detail', compact('membership'));
    }

    /**
     * Memperpanjang membership yang sudah ada
     */
    public function extend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_type' => 'required|exists:membership_types,id',
        ]);

        // Ambil membership aktif jika ada
        $activeMembership = Membership::where('user_id', $request->user_id)
            ->where('status', 'active')
            ->where('end_date', '>=', Carbon::now())
            ->first();

        // Jika tidak ada membership aktif, redirect ke store biasa
        if (!$activeMembership) {
            return $this->store($request);
        }

        // Jika ada membership aktif, buat membership extension
        $type = MembershipType::findOrFail($request->membership_type);

        // Buat membership baru untuk perpanjangan
        $membership = Membership::create([
            'user_id' => $request->user_id,
            'membership_type' => $type->id,
            'status' => 'pending_extension',
            'start_date' => $activeMembership->end_date, // Mulai setelah membership aktif berakhir
            'end_date' => $activeMembership->end_date->copy()->addMonths($type->duration_in_months),
            'payment_status' => 'pending',
            'price' => $type->price,
        ]);

        Log::info('Membership extension created', [
            'user_id' => $request->user_id,
            'active_membership_id' => $activeMembership->id,
            'new_membership_id' => $membership->id
        ]);

        // Redirect ke payment
        return redirect()->route('membership.payment', ['membershipId' => $membership->id]);
    }

    /**
     * Membatalkan membership (admin only)
     */
    public function cancel($id)
    {
        // Cek apakah user adalah admin
        if (!Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        $membership = Membership::findOrFail($id);

        // Update status membership
        $membership->update([
            'status' => 'cancelled'
        ]);

        // Update status user jika perlu
        $user = $membership->user;

        // Cek apakah user masih memiliki membership aktif lainnya
        $hasOtherActiveMembership = Membership::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>=', Carbon::now())
            ->where('id', '!=', $id)
            ->exists();

        if (!$hasOtherActiveMembership) {
            $user->update([
                'is_member' => false,
                'membership_status' => 'inactive'
            ]);
        }

        Log::info('Membership cancelled', [
            'membership_id' => $id,
            'user_id' => $membership->user_id,
            'cancelled_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Membership berhasil dibatalkan.');
    }


    public function checkExpirations()
    {
        $expiredMemberships = Membership::where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->get();

        foreach ($expiredMemberships as $membership) {
            $membership->update(['status' => 'expired']);

            // Cek apakah user memiliki membership aktif lainnya
            $hasOtherActiveMembership = Membership::where('user_id', $membership->user_id)
                ->where('status', 'active')
                ->where('end_date', '>=', Carbon::now())
                ->where('id', '!=', $membership->id)
                ->exists();

            if (!$hasOtherActiveMembership) {
                // Update status user
                $user = User::find($membership->user_id);
                if ($user) {
                    $user->update([
                        'is_member' => false,
                        'membership_status' => 'expired'
                    ]);
                }
            }

            Log::info('Membership expired', [
                'membership_id' => $membership->id,
                'user_id' => $membership->user_id
            ]);
        }

        return response()->json([
            'success' => true,
            'processed_count' => $expiredMemberships->count()
        ]);
    }
}
