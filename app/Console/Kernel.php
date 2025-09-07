<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Generate daily QR token at midnight
        $schedule->command('app:generate-daily-qr-token')
                 ->dailyAt('00:00')
                 ->description('Generate new daily QR token');

        // Send daily attendance summary at 6 PM
        $schedule->command('whatsapp:send-daily-summary')
                 ->dailyAt('18:00')
                 ->description('Send daily attendance summary to WhatsApp group');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}