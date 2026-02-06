<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Modules\Gps\Models\Gps;

class ExpirePayStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:expire-pay-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set pay_status to 0 for GPS records whose validity_date has expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');

        $this->info('Starting pay_status expiry update...');
        Log::info('[CRON] Starting pay_status expiry update', ['date' => $today]);

        try {
            $affected = Gps::where('pay_status', 1)
                ->whereNotNull('validity_date')
                ->whereDate('validity_date', '<', $today)
                ->update([
                    'pay_status' => 0,
                    'updated_at' => Carbon::now(),
                ]);

            $this->info("Updated {$affected} record(s).");
            Log::info('[CRON] pay_status expiry update completed', [
                'date' => $today,
                'updated' => $affected,
            ]);

            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            Log::error('[CRON] pay_status expiry update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 1;
        }
    }
}

