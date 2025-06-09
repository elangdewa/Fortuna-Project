<?php

namespace App\Exports;

use App\Models\Membership;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembershipExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Membership::with('user')->get()->map(function ($m) {
            return [
                'Nama' => $m->user->name,
                'Email' => $m->user->email,
                'Alamat' => $m->user->address,
                'Telepon' =>"'" . $m->user->phone,
                'Jenis Kelamin' => $m->user->gender,
                'Tipe Membership' => $m->membership_type,
                'Harga' => $m->price,
                'Status' => $m->status,
                'Mulai' => $m->start_date,
                'Berakhir' => $m->end_date,
                'Status Pembayaran' => $m->payment_status,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Alamat', 'Telepon', 'Jenis Kelamin', 'Tipe Membership', 'Harga', 'Status', 'Mulai', 'Berakhir', 'Status Pembayaran'];
    }
}
