<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // Daftar command buatan sendiri
    protected $commands = [
        \App\Console\Commands\CustomMakeFilamentUserCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Jadwal cron job jika ada
    }

    protected function commands(): void
    {
        // Autoload semua command dari folder Commands
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
