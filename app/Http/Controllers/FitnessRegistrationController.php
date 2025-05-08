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

        // Mulai transaksi database untuk mencegah race condition
        return DB::transaction(function() use ($request) {
            // Ambil jadwal dengan locking untuk update (mencegah konflik kuota)
            $schedule = ClassSchedule::with('fitnessClass')
                ->lockForUpdate()
                ->findOrFail($request->schedule_id);
            
            // Hitung jumlah pendaftar saat ini
            $currentRegistrations = $schedule->registrations()->count();
            
            // Ambil kapasitas efektif (dari schedule atau class)
            $capacity = $schedule->effective_capacity;
            
            // Cek apakah kuota masih tersedia
            if ($currentRegistrations >= $capacity) {
                return redirect()->back()->with('error', 'Maaf, kuota kelas sudah penuh.');
            }
            
            // Cek apakah user sudah terdaftar di jadwal ini
            if ($schedule->isRegisteredBy(Auth::id())) {
                return redirect()->back()->with('error', 'Anda sudah terdaftar di kelas ini.');
            }
            
            // Buat pendaftaran baru
            ClassRegistration::create([
                'user_id' => Auth::id(),
                'class_id' => $schedule->class_id,
                'schedule_id' => $request->schedule_id,
                'registered_at' => Carbon::now(),
            ]);
            
            $remainingSlots = $capacity - $currentRegistrations - 1;
            
            return redirect()->route('user.fitness')->with('success', 
                'Pendaftaran berhasil! Kuota tersisa: ' . $remainingSlots);
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