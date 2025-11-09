<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Produksi: hapus sesi yang idle lebih dari N jam (default 24 jam) setiap jam
        $schedule->call(function () {
            $hours     = (int) env('PRUNE_SESSION_AFTER_HOURS', 24);
            $threshold = now()->subHours($hours)->getTimestamp();

            $deleted = DB::table('sessions')
                ->where('last_activity', '<', $threshold)
                ->delete();

            $remaining = DB::table('sessions')->count();

            Log::info("Pruned {$deleted} old sessions (>{$hours}h). {$remaining} sessions remain.");
        })->hourly();
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
