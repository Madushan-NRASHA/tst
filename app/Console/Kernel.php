<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // This schedules your custom command to run daily.
        // Ensure that you have created the command (e.g., tasks:check-due).

        $schedule->command('tasks:check-due')->everyMinute();

        // $schedule->command('tasks:check-due')->dailyAt('16:49');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // Automatically load commands from the app/Console/Commands directory.
        $this->load(__DIR__.'/Commands');

        // Optionally, include the console routes file.
        require base_path('routes/console.php');
    }
}
