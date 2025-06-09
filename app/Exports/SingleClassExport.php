<?php

namespace App\Exports;
use App\Models\ClassSchedule;
use App\Models\FitnessClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SingleClassExport implements FromCollection, WithHeadings
{
    protected $scheduleId;

    public function __construct($scheduleId)
    {
        $this->scheduleId = $scheduleId;
    }

    public function collection()
    {
        $schedule = ClassSchedule::with(['fitnessClass', 'registrations.user'])->findOrFail($this->scheduleId);

        return $schedule->registrations->map(function ($r) use ($schedule) {
            return [
                'Kelas' => $schedule->fitnessClass->class_name,
                'Tanggal' => $schedule->date,
                'Jam' => $schedule->start_time . ' - ' . $schedule->end_time,
                'Nama Peserta' => $r->user->name,
                'Email' => $r->user->email,
                'Telepon' => "'" . $r->user->phone,
                'Status Pembayaran' => $r->payment_status,
                'Status Kehadiran' => $r->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['Kelas', 'Tanggal', 'Jam', 'Nama Peserta', 'Email', 'Telepon', 'Status Pembayaran', 'Status Kehadiran'];
    }
}
