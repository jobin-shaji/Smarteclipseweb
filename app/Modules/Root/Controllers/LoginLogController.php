<?php

namespace App\Modules\Root\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginLogController extends Controller
{
    /**
     * Login logs summary page
     * Shows first login of today & last login per user
     */

    public function index()
    {
    
    if (!auth()->check() || !auth()->user()->hasRole('root')) {
        abort(403, 'Unauthorized');
    }

    $logs = DB::table('login_logs')
        ->select(
            'user_id',
            'username',
            'role',

            // First login time today
            DB::raw("
                MIN(
                    CASE 
                        WHEN DATE(created_at) = CURDATE() 
                        THEN created_at 
                    END
                ) AS first_login_today
            "),

            // Office of first login today
            DB::raw("
                SUBSTRING_INDEX(
                    GROUP_CONCAT(
                        CASE 
                            WHEN DATE(created_at) = CURDATE() 
                            THEN office 
                        END
                        ORDER BY created_at ASC
                    ),
                    ',', 1
                ) AS first_login_office
            "),

            // Last login time (overall)
            DB::raw("MAX(created_at) AS last_login"),

            // Office of last login
            DB::raw("
                SUBSTRING_INDEX(
                    GROUP_CONCAT(
                        office 
                        ORDER BY created_at DESC
                    ),
                    ',', 1
                ) AS last_login_office
            ")
        )
        ->groupBy('user_id', 'username', 'role')
        ->orderByDesc('last_login')
        ->get();

    return view('Root::login-log', compact('logs'));
}


    /**
     * Show full login history of a specific user
     */
    public function show($user_id)
    {
        if(!auth()->user()->hasRole('root')) {
              abort(403, 'Unauthorized');
        }
        $history = DB::table('login_logs')
            ->where('user_id', $user_id)
            ->orderByDesc('created_at')
            ->paginate(25);

        if ($history->isEmpty()) {
            abort(404, 'No login records found');
        }

        return view('Root::login-logs-history', compact('history'));
    }
}
