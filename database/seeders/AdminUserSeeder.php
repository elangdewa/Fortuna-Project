<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '08123456789',
            'gender' => 'Laki-laki',
            'address' => 'Jl. Contoh No.1',
            'role' => 'admin',
            'password' => Hash::make('password'), // ganti kalau mau
          
        ]);
    }
}
