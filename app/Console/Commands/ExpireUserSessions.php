<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireUserSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire abc_user_sessions based on session.lifetime';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lifetime = config('session.lifetime');
        $cutoff = now()->subMinutes($lifetime);

        $affected = DB::table('abc_user_sessions')
            ->where('is_active', true)
            ->where('logged_in_at', '<', $cutoff)
            ->update([
                'logged_out_at' => DB::raw("DATE_ADD(logged_in_at, INTERVAL {$lifetime} MINUTE)"),
                'logout_type' => 'session_expired',
                'duration_minutes' => $lifetime,
                'is_active' => false,
                'updated_at' => now(),
            ]);

        $this->info("Expired {$affected} sessions.");

        return 0;
    }
}
