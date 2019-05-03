<?php


namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
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

        if($request->dealer == null){
            return response()->json([
                'gps' => Gps::all()->count(), 
                'dealers' => Dealer::all()->count(), 
                 'subdealers' => SubDealer::all()->count(),
                 'clients' => Client::all()->count(),
                'status' => 'dbcount'
            ]);
        }else{
            //  $sum_collections=TicketLog::where('depot_id',$request->depot)->whereDate('created_at', Carbon::today())->sum('total_amount');
            //      return response()->json([
            //     'trips' => TripLog::where('depot_id',$request->depot)->count(),
            //     'tickets' => TicketLog::where('depot_id',$request->depot)->whereDate('created_at', Carbon::today())->count(),
            //     'vehicles' => Vehicle::where('depot_id',$request->depot)->count(),
            //     'employees' => Employee::where('depot_id',$request->depot)->count(), 
            //     'collections'=>$sum_collections,
            //     'etms' => Etm::where('depot_id',$request->depot)->count(),
            //     'status' => 'dbcount',
            //     'expense' => Expense::where('depot_id',$request->depot)->whereDate('created_at', Carbon::today())->sum('amount')
            // ]);
        }

       
    }
}
