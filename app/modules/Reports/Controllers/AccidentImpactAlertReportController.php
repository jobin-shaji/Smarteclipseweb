<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\AccidentImpactAlertReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class AccidentImpactAlertReportController extends Controller
{
    public function accidentImpactAlertReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->withTrashed()
        ->get();
        return view('Reports::accident-impact-alert-report',['vehicles'=>$vehicles]);  
    }  
    public function accidentImpactAlertReportList(Request $request)
    {
        $single_vehicle_id = [];
        $client= $request->data['client'];
        $vehicle= $request->data['vehicle'];
        $from = $request->data['from_date'];
        $to = $request->data['to_date']; 
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::withTrashed()->where('client_id',$client)->get();             
            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 

            }
        }  
        $query =Alert::select(
            'id',
            'alert_type_id', 
            'device_time',    
            'gps_id',
            'latitude',
            'longitude', 
            'status'
        )
        ->with('alertType:id,description')
        ->with('gps.vehicle')
        ->orderBy('device_time', 'DESC');
        if($vehicle==0 || $vehicle==null)
        {
            $query = $query->whereIn('gps_id',$single_vehicle_id)
            ->where('alert_type_id',14);
            // ->where('status',1);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);               
            }
        }
        else
        {
            $query = $query->where('gps_id',$single_vehicle_ids)
            ->where('alert_type_id',14);
            // ->where('status',1);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        $accidentimpactalert = $query->get();   
        return DataTables::of($accidentimpactalert)
        ->addIndexColumn()
        ->addColumn('location', function ($accidentimpactalert) {
            $latitude= $accidentimpactalert->latitude;
            $longitude=$accidentimpactalert->longitude;          
            if(!empty($latitude) && !empty($longitude)){
                //Send request and receive json data by address
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap'); 
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
        ->addColumn('action', function ($accidentimpactalert) {   
         $b_url = \URL::to('/');           
            return "
            <a href=".$b_url."/alert/report/".Crypt::encrypt($accidentimpactalert->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new AccidentImpactAlertReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Accident-Impact-Alert-report.xlsx');
    } 

   
}