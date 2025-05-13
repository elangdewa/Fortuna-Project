<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipType;
use Illuminate\Http\Request;

class PaketMemberController extends Controller
{
    /**
     * Display a listing of the membership types and the form to add new ones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $membershipTypes = MembershipType::all();
        return view('admin.paketmember.paket', compact('membershipTypes'));
    }

    /**
     * Store a newly created membership type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_in_months' => 'required|integer|min:1',
        ]);

        MembershipType::create($request->all());

        return redirect()->route('admin.paketmember.index')
            ->with('success', 'Paket membership berhasil ditambahkan!');
    }

    /**
     * Update the specified membership type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_in_months' => 'required|integer|min:1',
        ]);

        $membershipType = MembershipType::findOrFail($id);
        $membershipType->update($request->all());

        return redirect()->route('admin.paketmember.index')
            ->with('success', 'Paket membership berhasil diperbarui!');
    }

  
    public function destroy($id)
    {
        $membershipType = MembershipType::findOrFail($id);
        
        try {
            // Delete the membership type
            $membershipType->delete();
            return redirect()->route('admin.paketmember.index')
                ->with('success', 'Paket membership berhasil dihapus!');
        } catch (\Exception $e) {
            // If the delete fails due to foreign key constraints (in use by members)
            return redirect()->route('admin.paketmember.index')
                ->with('error', 'Paket membership tidak dapat dihapus karena sedang digunakan!');
        }
    }

    public function showMembershipForm()
{
    $types = MembershipType::all(); // pastikan kolom 'price' dan 'duration_in_months' ada
    return view('nama_view_user', compact('types'));
}
}