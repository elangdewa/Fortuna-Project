<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Membership; // Pastikan model Membership udah ada


Route::get('/memberships/{id}', function ($id) {
    $membership = Membership::find($id);

    if (!$membership) {
        return response()->json(['message' => 'Membership tidak ditemukan.'], 404);
    }

    return response()->json([
        'id' => $membership->id,
        'name' => $membership->name,
        'price' => $membership->price,
        'duration_in_months' => $membership->duration_in_months,
    ]);
});
