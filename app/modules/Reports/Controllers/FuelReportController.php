<?php
namespace App\Modules\Reports\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Reports\Models\FuelUpdate;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\Vehicle\Models\DailyKm;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DataTables;

class FuelReportController extends Controller
{
    public function fuelReport()
    {
        $client_id                  =   \Auth::user()->client->id;
        $client_vehicles            =   (new Vehicle())->getVehicleListBasedOnClient($client_id);
        return view('Reports::fuel-report',['vehicles' =>$client_vehicles]);
    }
    public function fuelReportList(Request $request)
    {
        $vehicle_id                     =   $request->vehicle_id;
        $report_type                    =   $request->report_type;
        if($report_type==1)
        {
            $date                       =   date('Y-m-d',strtotime($request->date));
            $vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithSingleDate($vehicle_id,$date);
            foreach($vehicle_gps_ids as $vehicle_gps_id)
        {
            $single_vehicle_gps_ids[]   =   $vehicle_gps_id->gps_id;
        }
        }
        else{
            $search_month               =   $request->date;
            $month                      =   date('Ym',strtotime($search_month));
            //$vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithMonth($vehicle_id,$search_month);
            $yearmonth                  =   (new vehicleGps())->getYearAndMonthBasedOnVehicleId($vehicle_id);
            foreach($yearmonth as $each_yearmonth)
            {
                $gps_fitted_on          =   $each_yearmonth->gps_fitted_on;
                $gps_removed_on         =   $each_yearmonth->gps_removed_on;
                if($month >= $gps_fitted_on && $month <= $gps_removed_on)
                {
                    $single_vehicle_gps_ids[]   =   $each_yearmonth->gps_id;
                }
            }
        }
        $fuel_details                   =   (new FuelUpdate())->getFuelDetailsForReport($single_vehicle_gps_ids);
        if($report_type==1)
        {
            $date                       =   date('Y-m-d',strtotime($request->date));
            $fuel_details               =   $fuel_details->whereDate('created_at',$date);
        }
        else{
            $search_month               =   $request->date;
            $month                      =   date('m',strtotime($search_month));
            $fuel_details               =   $fuel_details->whereRaw('MONTH(created_at) = ?',[$month]);
        }
        $fuel_details                   =   $fuel_details->get();
        return DataTables::of($fuel_details)
        ->addIndexColumn()
        ->addColumn('vehicle', function ($fuel_details) {
            return $fuel_details->vehicleGps->vehicle->name;
        })
        ->addColumn('register_number', function ($fuel_details) {
            return $fuel_details->vehicleGps->vehicle->register_number;
         })
        ->make();
    }

    public function getFuelGraphDetails(Request $request)
    {

        $vehicle_id                     =   $request->vehicle_id;
        $report_type                    =   $request->report_type;
        if($report_type==1)
        {
            $date                       =   date('Y-m-d',strtotime($request->date));
            $vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithSingleDate($vehicle_id,$date);
            foreach($vehicle_gps_ids as $vehicle_gps_id)
        {
            $single_vehicle_gps_ids[]   =   $vehicle_gps_id->gps_id;
        }
        }
        else
        {
            $search_month               =   $request->date;
            $month                      =   date('Ym',strtotime($search_month));
            //$vehicle_gps_ids            =   (new VehicleGps())->getGpsDetailsBasedOnVehicleWithMonth($vehicle_id,$search_month);
            $yearmonth                  =   (new vehicleGps())->getYearAndMonthBasedOnVehicleId($vehicle_id);
            foreach($yearmonth as $each_yearmonth)
            {
                $gps_fitted_on          =   $each_yearmonth->gps_fitted_on;
                $gps_removed_on         =   $each_yearmonth->gps_removed_on;
                if($month >= $gps_fitted_on && $month <= $gps_removed_on)
                {
                    $single_vehicle_gps_ids[]   =   $each_yearmonth->gps_id;
                }
            }
        }
        $fuel_details                   =   (new FuelUpdate())->getFuelDetailsForReport($single_vehicle_gps_ids);
        if($report_type==1)
        {
            $date                       =    date('Y-m-d',strtotime($request->date));
            $fuel_details               =   $fuel_details->whereDate('created_at',$date);
            $fuel_km                    =   (new DailyKM())->getSumOfKmForFuelReportBasedOnDate($single_vehicle_gps_ids,$date);
        }
        else
        {
            $search_month               =   $request->date;
            $month                      =   date('m',strtotime($search_month));
            $fuel_details               =   $fuel_details->whereRaw('MONTH(created_at) = ?',[$month]);
            $fuel_km                    =   (new DailyKM())->getSumOfKmForFuelReportBasedOnMonth($single_vehicle_gps_ids,$month);
        }
        $fuel_details                   =   $fuel_details->get();
        $fuel_km                        =   round($fuel_km/1000);
        if(sizeof($fuel_details) != 0)
        {
            $percentage                 =   [];
            $date_time                  =   [];
            foreach($fuel_details as $single_details)
            {
                $percentage[]           =   $single_details->percentage;
                $date_time[]            =   date('Y-m-d H:i:s',strtotime($single_details->created_at));
            }
            $response                   =   array(
                                                'status'    =>  1,
                                                'message'   =>  'success',
                                                "percentage"=>  $percentage,
                                                "date_time" =>  $date_time,
                                                "fuel_km"   =>  $fuel_km
                                            );
        }
        else{
            $response                   =   array(
                                                'status'    =>  0,
                                                'message'   =>  'failed'
                                            );
        }
        return response()->json($response);
    }

}