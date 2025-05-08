<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalTrainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PersonalTrainerOrder;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $trainers = PersonalTrainer::where('name', 'like', '%' . $search . '%')
                           ->orWhere('experience', 'like', '%' . $search . '%')
                           ->get();

        return view('admin.trainer.trainer', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'experience' => 'required|string',
        ]);
    
        PersonalTrainer::create([
            'name' => $request->name,
            'experience' => $request->experience,
        ]);
    
        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $trainer = PersonalTrainer::findOrFail($id);
        return view('admin.trainer.edit', compact('trainer'));
    }

    public function update(Request $request, $id)
    {
        $trainer = PersonalTrainer::findOrFail($id);
        $trainer->name = $request->name;
        $trainer->experience = $request->experience;
        $trainer->save();
    
        return redirect()->route('admin.trainers.index')->with('success', 'Trainer updated successfully!');
    }
    

    public function destroy($id)
    {
        $trainer = PersonalTrainer::findOrFail($id);
        $trainer->delete();

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil diperbarui!');

    }
}
