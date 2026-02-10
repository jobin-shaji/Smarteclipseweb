<?php

namespace App\Modules\Root\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UserSessionsController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->hasRole('root')) {
            abort(403, 'Unauthorized');
        }

        $sessions = DB::table('abc_user_sessions')
            ->select(
                'user_id',
                'username',
                'role',

                // First login time today (logged_in_at)
                DB::raw("MIN(CASE WHEN DATE(logged_in_at) = CURDATE() THEN logged_in_at END) AS first_login_today"),

                // Office of first login today
                DB::raw("SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN DATE(logged_in_at) = CURDATE() THEN login_office END ORDER BY logged_in_at ASC), ',', 1) AS first_login_office"),

                // Last logout time (overall)
                DB::raw("MAX(logged_out_at) AS last_logout"),

                // Office of last logout
                DB::raw("SUBSTRING_INDEX(GROUP_CONCAT(login_office ORDER BY logged_out_at DESC), ',', 1) AS last_logout_office"),

                // Last logout time for today
                DB::raw("(
                    SELECT MAX(s2.logged_out_at) FROM abc_user_sessions s2
                    WHERE s2.user_id = abc_user_sessions.user_id
                    AND DATE(s2.logged_out_at) = CURDATE()
                ) AS last_logout_today")
            )
            ->groupBy('user_id', 'username', 'role')
            ->orderByDesc('last_logout')
            ->get();

        return view('Root::user-sessions', compact('sessions'));
    }

    public function show($encrypted_id)
    {
        if (!auth()->user()->hasRole('root')) {
            abort(403, 'Unauthorized');
        }

        try {
            $user_id = decrypt($encrypted_id);
        } catch (DecryptException $e) {
            abort(404, 'Invalid identifier');
        }

        $history = DB::table('abc_user_sessions')
            ->where('user_id', $user_id)
            ->orderByDesc('logged_in_at')
            ->paginate(25);

        if ($history->isEmpty()) {
            abort(404, 'No session records found');
        }

        return view('Root::user-sessions-history', compact('history'));
    }
}
