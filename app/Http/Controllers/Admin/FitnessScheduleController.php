<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitnessClass;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;

class FitnessScheduleController extends Controller
{
    public function index($classId)
    {
        $class = FitnessClass::with('schedules')->findOrFail($classId);
        return view('admin.fitness.schedules', compact('class'));
    }

    public function store(Request $request, $classId)
    {
        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255'
        ]);

        $class = FitnessClass::findOrFail($classId);
        
        $class->schedules()->create([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->back()
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function update(Request $request, $scheduleId)
    {
        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255'
        ]);

        $schedule = ClassSchedule::findOrFail($scheduleId);
        $schedule->update($request->all());

        return redirect()->back()
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($scheduleId)
    {
        $schedule = ClassSchedule::findOrFail($scheduleId);
        $schedule->delete();

        return redirect()->back()
            ->with('success', 'Jadwal berhasil dihapus');
    }
}