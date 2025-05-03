<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipType; // Ganti dengan model yang benar
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Membership;

    
class AdminMemberController extends Controller
{
    public function create()
    {
        $memberships = MembershipType::all()->map(function($item) {
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'address' => 'nullable|string|max:255',
                'gender' => 'nullable|string|max:20',
                'phone' => 'nullable|string|max:20',
                'membership_type_id' => 'nullable|exists:membership_types,id',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
            ]);

            // Add a default password since it's not in the form
            $userData = array_merge($validatedData, [
                'role' => 'member',
                'is_member' => $request->membership_type_id ? 1 : 0,
                'password' => Hash::make('password123'), // Default password
                'join_date' => $request->start_date,
                'expire_date' => $request->end_date,
            ]);
        
            // Create user with explicit fields instead of mass assignment
            $user = new User();
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->address = $userData['address'] ?? null;
            $user->gender = $userData['gender'] ?? null;
            $user->phone = $userData['phone'] ?? null;
            $user->role = $userData['role'];
            $user->is_member = $userData['is_member'];
            $user->membership_type_id = $userData['membership_type_id'] ?? null;
            $user->password = $userData['password'];
            $user->join_date = $userData['join_date'] ?? null;
            $user->expire_date = $userData['expire_date'] ?? null;
        
            $saved = $user->save();
        
            if (!$saved) {
                throw new \Exception('Failed to save user to database');
            }

            return redirect()->route('admin.members.create')->with('success', 'Member berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
    public function index(Request $request)
    {
        $query = User::where('role', 'member')->with('membershipType');
        
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
            return view('admin.members.table', compact('members')); // Return only the table
        }
    
        return view('admin.members.view', compact('members')); // Normal view without AJAX
    }
public function edit($id)
{
    $member = User::findOrFail($id);
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
        'membership_type_id' => 'nullable|exists:membership_types,id',
    ]);

    $member->update($validatedData);

    return redirect()->route('members.view')->with('success', 'Member berhasil diperbarui.');
}

public function destroy($id)
{
    $member = User::findOrFail($id);
    $member->delete();

    return redirect()->route('members.view')->with('success', 'Member berhasil dihapus.');
}

}

