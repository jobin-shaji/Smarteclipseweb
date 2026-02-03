<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LogLogout
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        try {
            $sessionId = session()->getId();
        } catch (\Throwable $e) {
            $sessionId = null;
        }

        $userId = null;
        if (isset($event->user) && is_object($event->user)) {
            $userId = $event->user->id ?? null;
        }

        if (Schema::hasTable('abc_logout_logs')) {
            try {
                DB::table('abc_logout_logs')->insert([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'logged_out_at' => now(),
                    'reason' => 'manual',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Throwable $e) {
                // avoid throwing from listener; log to DB failed silently
            }
        }
    }
}
