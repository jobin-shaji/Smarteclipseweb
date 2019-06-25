<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\ZigZagDrivingReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class ZigZagDrivingReportController extends Controller
{
    public function zigZagDrivingReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::zig-zag-driving-report',['vehicles'=>$vehicles]);  
    }  
    public function zigZagDrivingReportList(Request $request)
    {
        $client= $request->data['client'];
        $vehicle= $request->data['vehicle'];
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];    
        $query =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'vehicle_id',
            'gps_id',
            'client_id',  
            'latitude',
            'longitude', 
            'status'
        )
        ->with('alertType:id,description')
        ->with('vehicle:id,name,register_number');
        if($vehicle==0 || $vehicle==null)
        {
            $query = $query->where('client_id',$client)
            ->where('alert_type_id',13)
            ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        else
        {
             $query = $query->where('client_id',$client)
            ->where('alert_type_id',13)
            ->where('vehicle_id',$vehicle)
            ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        
        $zigzagdriving = $query->get();   

        return DataTables::of($zigzagdriving)
        ->addIndexColumn()
        ->addColumn('location', function ($zigzagdriving) {
            $latitude= $zigzagdriving->latitude;
            $longitude=$zigzagdriving->longitude;          
            if(!empty($latitude) && !empty($longitude)){
                //Send request and receive json data by address
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
                $output = json_decode($geocodeFromLatLong);         
                $status = $output->status;
                //Get address from json data
                $address = ($status=="OK")?$output->results[1]->formatted_address:'';
                //Return address of the given latitude and longitude
                if(!empty($address)){
                     $location=$address;
                return $location;                
                }        
            }
        })
         ->addColumn('action', function ($zigzagdriving) {              
            return "
            <a href=/alert/report/".Crypt::encrypt($zigzagdriving->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    } 
    public function export(Request $request)
    {
       return Excel::download(new ZigZagDrivingReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'zigzag-driving-report.xlsx');
    } 
   
}