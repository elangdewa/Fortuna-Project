<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitnessClass;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\ClassScheduleInstance;
use Carbon\Carbon;

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
        'date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string|max:255'
    ]);

    $class = FitnessClass::findOrFail($classId);

    // Hitung otomatis hari dari tanggal
    $dayOfWeek = Carbon::parse($request->date)->format('l'); // e.g., "Monday"

    $class->schedules()->create([
        'date' => $request->date,
        'day_of_week' => $dayOfWeek,
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
    'date' => 'required|date',
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

 public function scheduleMembers(ClassSchedule $schedule)
{
    // Eager load relationships to avoid N+1 queries
    $schedule->load([
        'fitnessClass',
        'registrations.user',
        'registrations' => function($query) {
            $query->orderBy('registered_at', 'desc');
        }
    ]);

    $registrations = $schedule->registrations;
    $activeMembers = $registrations->where('status', 'active')->count();
    $totalCapacity = $schedule->getEffectiveCapacityAttribute();

    return view('admin.fitness.members', compact(
        'schedule',
        'registrations',
        'activeMembers',
        'totalCapacity'
    ));
}

public function generateInstance(Request $request)
{
    $offset = (int) $request->input('weekOffset', 0); // Pastikan integer

    $startOfWeek = now()->startOfWeek()->addWeeks($offset);

    $mapDayToIndex = [
        'Monday' => 0,
        'Tuesday' => 1,
        'Wednesday' => 2,
        'Thursday' => 3,
        'Friday' => 4,
        'Saturday' => 5,
        'Sunday' => 6,
    ];

    $schedules = ClassSchedule::all();
    $createdCount = 0;

    foreach ($schedules as $schedule) {
        $day = $schedule->day_of_week;

        if (!isset($mapDayToIndex[$day])) continue;

        $date = $startOfWeek->copy()->addDays($mapDayToIndex[$day]);

        $instance = ClassScheduleInstance::updateOrCreate([
            'schedule_id' => $schedule->id,
            'date' => $date->format('Y-m-d'),
        ], [
            'class_id' => $schedule->class_id,
            'start_time' => $schedule->start_time,
            'end_time' => $schedule->end_time,
        ]);

        $createdCount++;
    }

    return redirect()->back()->with('success', "Jadwal berhasil dibuat untuk minggu ke-{$offset} ($createdCount entri).");
}
}
