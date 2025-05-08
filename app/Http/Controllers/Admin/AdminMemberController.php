<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminMemberController extends Controller
{
    public function create()
    {
        $memberships = MembershipType::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'duration' => $item->duration_in_months
            ];
        });

        return view('admin.members.create', [
            'memberships' => MembershipType::all(),
            'memberships_json' => $memberships->toJson()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'membership_type' => 'required|exists:membership_types,id',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'role' => 'member',
            'is_member' => 1,
            'password' => Hash::make('password123'),
        ]);

       
        $type = MembershipType::findOrFail($validatedData['membership_type']);
        $startDate = now();
        $endDate = now()->addMonths($type->duration_in_months);

        // Buat membership
        Membership::create([
            'user_id' => $user->id,
            'membership_type' => $type->id,
            'price' => $type->price,
            'status' => 'active',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'payment_status' => 'paid',
        ]);

        return redirect()->route('members.create')->with('success', 'Member berhasil ditambahkan!');
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'member')
            ->with(['membership' => function ($query) {
                $query->with('type');
            }]);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $members = $query->get();

        if ($request->ajax()) {
            return view('admin.members.table', compact('members'));
        }

        return view('admin.members.view', compact('members'));
    }

    public function edit($id)
    {
        // Menggunakan with() untuk memuat relasi membership dan type
        $member = User::with('membership.type')->findOrFail($id);
        $memberships = MembershipType::all();

        return view('admin.members.edit', compact('member', 'memberships'));
    }

    public function update(Request $request, $id)
    {
        $member = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'membership_type_id' => 'required|exists:membership_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,inactive',
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        // Update data user
        $member->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
        ]);

        // Update atau buat membership
        $membership = Membership::firstOrNew(['user_id' => $member->id]);
        $type = MembershipType::find($request->membership_type_id);

        $membership->membership_type = $request->membership_type_id;
        $membership->start_date = $request->start_date;
        $membership->end_date = $request->end_date;
        $membership->price = $type->price ?? 0;
        $membership->status = $request->status;
        $membership->payment_status = $request->payment_status;
        $membership->save();

        // Pastikan user memiliki flag is_member = 1
        if ($member->is_member != 1) {
            $member->update(['is_member' => 1]);
        }

        return redirect()->route('members.view')->with('success', 'Member & membership berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()->route('members.view')->with('success', 'Member berhasil dihapus.');
    }

    public function checkMembershipConsistency()
    {
        // User yang is_member=1 tapi tidak punya membership
        $inconsistentUsers = User::where('is_member', 1)
            ->whereDoesntHave('membership')
            ->get();

        // Perbaiki data yang tidak konsisten
        foreach ($inconsistentUsers as $user) {
            $user->update(['is_member' => 0]);
        }

        return "Data membership telah diperiksa. " . count($inconsistentUsers) . " user diperbaiki.";
    }
}
