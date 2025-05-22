<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
   public function index()
{
    $admins = User::where('role', 'admin')->get();

    return view('superadmin.admins', compact('admins'));
    
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin created successfully');
    }

    public function update(Request $request, $id)
{
    $admin = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'nullable|min:8', // Password boleh kosong (tidak diubah)
    ]);

    $admin->name = $validated['name'];
    $admin->email = $validated['email'];

    if (!empty($validated['password'])) {
        $admin->password = Hash::make($validated['password']);
    }

    $admin->save();

    return redirect()->route('superadmin.admins.index')
        ->with('success', 'Admin updated successfully');
}

public function edit($id)
{
    $admin = User::findOrFail($id);
    return response()->json($admin);
}
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin deleted successfully');
    }
}
