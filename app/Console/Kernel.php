<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\UpdatePartnerLevels::class,
        // Add other command classes here if you register them explicitly
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('partners:update-levels')->monthly();
        $schedule->command('sponsorships:update-statuses')->daily();
    }

    protected function commands(): void
    {
        // Auto-load all commands in app/Console/Commands
        $this->load(__DIR__ . '/Commands');

        // Keep route-based artisan commands
        require base_path('routes/console.php');
    }
}
