<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\FitnessClass;
use Illuminate\Support\Str;
use Carbon\Carbon;
class FitnessViewController extends Controller
{
     public function index()
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $classes = FitnessClass::with('schedules')->get();

        foreach ($classes as $class) {
            $class->jadwal_ditampilkan = $class->schedules->map(function ($schedule) use ($days) {
                $hari = $days[$schedule->day_of_week] ?? $schedule->day_of_week;
                $mulai = Carbon::parse($schedule->start_time)->format('H:i');
                $selesai = Carbon::parse($schedule->end_time)->format('H:i');

                return "$hari ($mulai - $selesai)";
            });
        }

        return view('superadmin.fitness', compact('classes'));
    }
}
