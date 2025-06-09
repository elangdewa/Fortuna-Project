<?php

namespace App\Schedules;

use Illuminate\Console\Scheduling\Schedule;

class GenerateWeeklyClassSchedulesSchedule
{
    public function __invoke(Schedule $schedule): void
    {
        $schedule->command('generate:weekly-class-schedules')
                 ->weeklyOn(0, '01:00'); // Minggu jam 1 pagi
    }
}
