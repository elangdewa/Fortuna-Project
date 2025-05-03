<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalTrainersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('personal_trainers')->insert([
            [
                'id' => '1',
                'name' => 'Andi Setiawan',
                'experience' => '5 years of experience in weight training and cardio coaching.',
                'user_id' => 16,
            ],
            [
                'id' => '2',
                'name' => 'Rina Kartika',
                'experience' => 'Specialist in Zumba and aerobics with 3 years experience.',
                'user_id' => 19,
            ],
            [
                'id' => '3',
                'name' => 'Budi Prasetyo',
                'experience' => 'Certified personal trainer for strength and endurance. 4 years in the field.',
                'user_id' => 18,
            ],
        ]);
    }
}
