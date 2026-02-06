<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Modules\Esim\Controllers\EsimController;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GeneralDemandTrips::class,
        Commands\TripM::class,
        Commands\VehicleTrips::class,
        Commands\VehicleOdometer::class,
        Commands\OldTrips::class,
        Commands\IndividualTrips::class,
        Commands\Esim::class,
        Commands\VehicleCmc::class,
        Commands\AutoAssignRenewals::class,
        Commands\ExpirePayStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('General:DemandTrips')->everyMinute();
        $schedule->command('vehicle:trips')->dailyAt('03:00');
        $schedule->command('vehicle:odometer')->dailyAt('06:00');
        $schedule->command('esim:pdf')->monthlyOn(20, '12:00');
        $schedule->command('invoices:generate')->dailyAt('03:00');
        
        // Auto-assign expiring GPS devices to call centers for renewal
        $schedule->command('renewals:auto-assign')->dailyAt('02:00');

        // Expire pay_status when validity_date is in the past
        $schedule->command('gps:expire-pay-status')->dailyAt('01:30');
    }
  


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
