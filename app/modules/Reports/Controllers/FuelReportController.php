<?php
namespace App\Modules\Reports\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Reports\Models\FuelUpdate;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\DailyKm;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DataTables;
class FuelReportController extends Controller
{
    public function fuelReport()
    {
        $client_id = \Auth::user()->client->id;
        $client_vehicles = Vehicle::select(
            'id',
            'gps_id',
            'name',
            'register_number'
        )
        ->where('client_id', $client_id)
        ->withTrashed()
        ->get();
        return view('Reports::fuel-report',['vehicles' =>$client_vehicles]);
    }
    public function fuelReportList(Request $request)
    {
        $gps_id     =   $request->gps_id;
        $report_type =$request->report_type;

        $fuel_details = FuelUpdate::select(
            'id',
            'gps_id',
            'percentage',
            'created_at'
        )
        ->where('gps_id', $gps_id)
        ->with('gps.vehicle');
        if($report_type==1)
        {
            $date       =   date('Y-m-d',strtotime($request->date));
            $fuel_details =$fuel_details->whereDate('created_at',$date);
        }
        else{
            $month=$request->date;
            $fuel_details =  $fuel_details->whereRaw('MONTH(created_at) = ?',[$month]);
        }
        $fuel_details = $fuel_details->orderBy('created_at', 'ASC')
        ->get();
        return DataTables::of($fuel_details)
        ->addIndexColumn()
        ->addColumn('vehicle', function ($fuel_details) {
           return $fuel_details->gps->vehicle->name;
        })
        ->addColumn('register_number', function ($fuel_details) {
            return $fuel_details->gps->vehicle->register_number;
         })
        ->make();
    }







    public function getFuelGraphDetails(Request $request)
    {

        $gps_id     =   $request->gps_id;
        $report_type =$request->report_type;
        $fuel_details = FuelUpdate::select(
            'percentage',
            'created_at'
        )
        ->where('gps_id', $gps_id);
        if($report_type==1)
        {
            $date       =   date('Y-m-d',strtotime($request->date));
            $fuel_details =  $fuel_details->whereDate('created_at',$date);
        }
        else{
            $month=$request->date;
            $fuel_details =  $fuel_details->whereRaw('MONTH(created_at) = ?',[$month]);
        }
        $fuel_details =  $fuel_details->orderBy('created_at', 'ASC')
        ->get();
        if($report_type==1)
        {
            $fuel_km = DailyKM::select(
                'km'
            )
            ->where('gps_id', $gps_id)
            ->whereDate('date',$date)
            ->first();
        }
        else
        {
            $month=$request->date;
            $fuel_km = DailyKM::select(
                \DB::raw('sum(km) as km'),
                'date'
            )
            ->where('gps_id', $gps_id)
            ->whereRaw('MONTH(date) = ?',[$month])
            ->first();
        }

        if(sizeof($fuel_details) != 0)
        {
            $percentage = [];
            $date_time = [];
            foreach($fuel_details as $single_details)
            {
                $percentage[] = $single_details->percentage;
                $date_time[]  = date('Y-m-d H:i:s',strtotime($single_details->created_at));
            }
            $response=array(
                'status'    =>  1,
                'message'   =>  'success',
                "percentage"=>  $percentage,
                "date_time" =>  $date_time,
                "fuel_km"   =>  $fuel_km
            );
        }
        else{
            $response=array(
                'status'    =>  0,
                'message'   =>  'failed'
            );
        }
        return response()->json($response);
    }

}