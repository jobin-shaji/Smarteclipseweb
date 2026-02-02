<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Throwable;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        try {
            $user = $event->user;

            // Log ONLY Sales and Call Center roles
            if (! $user->hasAnyRole(['root','servicer','operations','sales','Call_Center','Production Finance','StoreKeeper','user'])) {
                return;
            }

            $request = request();
            $userAgent = $request->userAgent();
            $ip = $request->ip();

            DB::table('login_logs')->insert([
                'user_id'    => $user->id,
                'username'   => $user->username ?? '',
                'role'       => $user->getRoleNames()->first(),
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'platform'   => $this->detectPlatform($userAgent),
                'office'     => $this->detectOffice($ip),
                'created_at' => now(),
            ]);
        } catch (Throwable $e) {
            // IMPORTANT:
            // Never allow logging errors to break login
            // Optionally log this error to Laravel log file
            // logger()->error($e->getMessage());
        }
    }

    /**
     * Detect platform from User-Agent
     */
    private function detectPlatform($agent)
    {
        if (stripos($agent, 'Android') !== false) {
            return 'Android';
        }

        if (stripos($agent, 'iPhone') !== false || stripos($agent, 'iPad') !== false) {
            return 'iOS';
        }

        if (stripos($agent, 'Windows') !== false) {
            return 'Windows';
        }

        if (stripos($agent, 'Macintosh') !== false) {
            return 'macOS';
        }

        if (stripos($agent, 'Linux') !== false) {
            return 'Linux';
        }

        return 'Unknown';
    }
    private function detectOffice($ip)
    {
        if (substr($ip, 0, 8) === '117.250.') {
            return 'peruva';
        }

        if (substr($ip, 0, 7) === '103.21.') {
            return 'Bangalore Office';
        }
  
        if (substr($ip, 0, 8) === '117.240.') {
            return 'Trivandrum Office';
        }
        
        return 'unknown';
    }

}
