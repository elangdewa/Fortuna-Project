<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@fortuna.com',
            'password' => Hash::make('Fortuna123!'),
            'role' => 'superadmin',
            'is_member' => false,
            'gender' => 'male', // adjust as needed
            'phone' => '081234567890', // adjust as needed
            'address' => 'Fortuna Gym Address', // adjust as needed
            
        ]);
    }
}
