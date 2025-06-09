<?php

namespace App\Exports;

use App\Models\ClassSchedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FitnessClassWithMembersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $data = [];

        $schedules = ClassSchedule::with(['fitnessClass', 'registrations.user'])->get();

        foreach ($schedules as $schedule) {
            $formattedDate = $schedule->date
                ? $schedule->date->locale('id')->translatedFormat('l, d F Y')
                : 'Belum Ditentukan';

            foreach ($schedule->registrations as $registration) {
                $data[] = [
                    'Kelas' => $schedule->fitnessClass->class_name,
                    'Tanggal' => $formattedDate,
                    'Jam' => $schedule->start_time . ' - ' . $schedule->end_time,
                    'Nama Peserta' => $registration->user->name,
                    'Email' => $registration->user->email,
'Telepon' => "'" . $registration->user->phone,
                    'Status Pembayaran' => $registration->payment_status,
                    'Status Kehadiran' => $registration->status,
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Kelas',
            'Tanggal',
            'Jam',
            'Nama Peserta',
            'Email',
            'Telepon',
            'Status Pembayaran',
            'Status Kehadiran'
        ];
    }
}
