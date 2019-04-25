<?php


namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Ticket\Models\TicketLog;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Employee\Models\Employee;
use App\Modules\Trip\Models\TripLog;
use App\Modules\Depot\Models\Depot;
use App\Modules\Etm\Models\Etm;
use App\Modules\Route\Models\Route;
use App\Modules\Stage\Models\Stage;
use App\Modules\Expense\Models\Expense;
use DataTables;
use DB;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('Dashboard::dashboard');         
    }

    public function dashCount(Request $request){

        if($request->depot == null){
            return response()->json([
                'stages' => Stage::all()->count(),
                'routes' => Route::all()->count(),
                'vehicles' => Vehicle::all()->count(),
                'employees' => Employee::all()->count(), 
                'depots' => Depot::all()->count(),
                'etms' => Etm::all()->count(),
                'status' => 'dbcount'
            ]);
        }else{
             $sum_collections=TicketLog::where('depot_id',$request->depot)->whereDate('created_at', Carbon::today())->sum('total_amount');
                 return response()->json([
                'trips' => TripLog::where('depot_id',$request->depot)->count(),
                'tickets' => TicketLog::where('depot_id',$request->depot)->whereDate('created_at', Carbon::today())->count(),
                'vehicles' => Vehicle::where('depot_id',$request->depot)->count(),
                'employees' => Employee::where('depot_id',$request->depot)->count(), 
                'collections'=>$sum_collections,
                'etms' => Etm::where('depot_id',$request->depot)->count(),
                'status' => 'dbcount',
                'expense' => Expense::where('depot_id',$request->depot)->whereDate('created_at', Carbon::today())->sum('amount')
            ]);
        }

       
    }
}
