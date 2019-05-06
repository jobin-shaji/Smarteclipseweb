<?php


namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Vehicle\Models\Vehicle;
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
        $user = $request->user();
        $subdealers=Dealer::where('user_id',$user->id)->first();
        $client=SubDealer::where('user_id',$user->id)->first();
        if($user->hasRole('root')){
            return response()->json([
                'gps' => Gps::all()->count(), 
                'dealers' => Dealer::all()->count(), 
                'subdealers' => SubDealer::all()->count(),
                'clients' => Client::all()->count(),
                'vehicles' => Vehicle::all()->count(),
                'status' => 'dbcount'
            ]);
        }
        else if($user->hasRole('dealer')){
            return response()->json([
                'subdealers' => SubDealer::where('dealer_id',$subdealers->id)->count(),
                'gps' => Gps::where('user_id',$user->id)->count(),
                'status' => 'dbcount'           
            ]);
        }
        else if($user->hasRole('sub_dealer')){
            return response()->json([
                'clients' => Client::where('sub_dealer_id',$client->id)->count(),
                'gps' => Gps::where('user_id',$user->id)->count(),
                'status' => 'dbcount'           
            ]);
        }
        else if($user->hasRole('client')){
            return response()->json([
                'gps' => Gps::where('user_id',$user->id)->count(),
                'status' => 'dbcount'           
            ]);
        }       
    }
}
