<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Sales\Controllers\RenewalAutomationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AutoAssignRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewals:auto-assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically assign expiring GPS devices to call centers for renewal follow-up';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting automatic renewal assignment...');
        Log::info('[CRON] Starting automatic renewal assignment via scheduled task');
        
        try {
            // Create controller instance
            $controller = new RenewalAutomationController();
            
            // Create empty request
            $request = new Request();
            
            // Execute auto-assignment
            $response = $controller->executeAutoAssignment($request);
            $result = $response->getData(true);
            
            if ($result['success']) {
                $this->info("Success: {$result['message']}");
                $this->info("Processed: {$result['processed']}");
                $this->info("Assigned: {$result['assigned']}");
                $this->info("Skipped: {$result['skipped']}");
                
                Log::info('[CRON] Auto-assignment completed successfully', [
                    'processed' => $result['processed'],
                    'assigned' => $result['assigned'],
                    'skipped' => $result['skipped']
                ]);
                
                return 0; // Success
            } else {
                $this->error("Failed: {$result['message']}");
                Log::error('[CRON] Auto-assignment failed', ['error' => $result['message']]);
                return 1; // Failure
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            Log::error('[CRON] Auto-assignment exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1; // Failure
        }
    }
}
