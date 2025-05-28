<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\ClassRegistration;
use App\Models\FitnessClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FitnessRegistrationController extends Controller
{
    public function create()
    {
        // Ambil semua jadwal beserta fitness class dan hitung jumlah pendaftar
        $schedules = ClassSchedule::with('fitnessClass')
            ->withCount('registrations')
            ->get();
            
        // Ambil registrasi user yang sudah terdaftar
        $userRegistrations = ClassRegistration::with(['schedule.fitnessClass', 'fitnessClass'])
                                ->where('user_id', Auth::id())
                                ->get();

        return view('user.fitness', [
            'schedules' => $schedules,
            'userRegistrations' => $userRegistrations
        ]);
    }
    
  public function store(Request $request)
{
    $request->validate([
        'schedule_id' => 'required|exists:class_schedules,id',
    ]);

    return DB::transaction(function() use ($request) {
        $schedule = ClassSchedule::with('fitnessClass')
            ->lockForUpdate()
            ->findOrFail($request->schedule_id);

        $currentRegistrations = $schedule->registrations()->count();
        $capacity = $schedule->effective_capacity;

        if ($currentRegistrations >= $capacity) {
            // Return JSON error
            return response()->json(['success' => false, 'message' => 'Maaf, kuota kelas sudah penuh.'], 422);
        }

        if ($schedule->isRegisteredBy(Auth::id())) {
            // Return JSON error
            return response()->json(['success' => false, 'message' => 'Anda sudah terdaftar di kelas ini.'], 422);
        }

        $registration = ClassRegistration::create([
            'user_id' => Auth::id(),
            'class_id' => $schedule->class_id,
            'schedule_id' => $request->schedule_id,
            'registered_at' => now(),
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        $remainingSlots = $capacity - $currentRegistrations - 1;

        // Return JSON success
        return response()->json([
            'success' => true,
            'registration' => $registration,
            'remaining_slots' => $remainingSlots
        ]);
    });
}
    
    // Jika ingin menambahkan fitur pembatalan pendaftaran
    public function cancel(Request $request, $registrationId)
    {
        $registration = ClassRegistration::where('id', $registrationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Ambil informasi jadwal untuk pesan sukses
        $schedule = $registration->schedule;
        
        $registration->delete();
        
        return redirect()->route('user.fitness')->with('success', 
            'Pendaftaran kelas ' . $schedule->fitnessClass->class_name . ' berhasil dibatalkan.');
    }
}