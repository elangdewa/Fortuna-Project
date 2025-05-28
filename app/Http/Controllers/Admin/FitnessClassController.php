<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitnessClass;
use App\Models\ClassRegistration;
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;



class FitnessClassController extends Controller
{
    public function index()
    {
        $classes = FitnessClass::all();


        return view('admin.fitness.fitness', [
            'classes' => $classes
        ]);
    }
    // Rest of the methods remain the same
    public function store(Request $request)
{
    $request->validate([
        'class_name' => 'required|string|max:255',
        'description' => 'nullable|string',

        'capacity' => 'required|integer|min:1',
    ]);

    FitnessClass::create($request->all());

    return redirect()->route('admin.fitness.index')
    ->with('success', 'Kelas fitness berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    $class = FitnessClass::findOrFail($id);

    $request->validate([
        'class_name' => 'required|string|max:255',
        'description' => 'nullable|string',

        'capacity' => 'required|integer|min:1',
    ]);

    $class->update($request->all());

    return redirect()->route('admin.fitness.index')
    ->with('success', 'Kelas fitness berhasil ditambahkan!');
}

public function destroy($id)
{
    $class = FitnessClass::findOrFail($id);
    $class->delete();

    return redirect()->route('admin.fitness.index')
    ->with('success', 'Kelas fitness berhasil ditambahkan!');
}

public function members(FitnessClass $class)
{
    $registrations = ClassRegistration::with(['user', 'schedule'])
        ->where('class_id', $class->id)  // Changed: directly query class_id
        ->where('payment_status', 'paid')
        ->orderBy('registered_at', 'desc')
        ->get();

    return view('admin.fitness.members', compact('class', 'registrations'));
}

}
