<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\MainBatteryDisconnectReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Warehouse\Models\GpsStock;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class MainBatteryDisconnectReportController extends Controller
{
    public function mainBatteryDisconnectReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::main-battery-disconnect-report',['vehicles'=>$vehicles]);  
    } 
    public function mainBatteryDisconnectReportList(Request $request)
    {
        $client= $request->data['client'];
        $vehicle= $request->data['vehicle'];
        $from = $request->data['from_date'];
        $to = $request->data['to_date']; 
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
        ->with('gps.vehicle');
        if($vehicle==0 || $vehicle==null)
        {
            $gps_stocks=GpsStock::where('client_id',$client)->get();
            $gps_list=[];
            foreach ($gps_stocks as $gps) {
                $gps_list[]=$gps->gps_id;
            }
            $query = $query->whereIn('gps_id',$gps_list)
                            ->where('alert_type_id',11);
            if($from){
               $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        else
        {
            $vehicle=Vehicle::find($vehicle); 
            $query = $query->where('alert_type_id',11)->where('gps_id',$vehicle->gps_id);
            if($from){
                $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $query = $query->whereDate('device_time', '>=', $search_from_date)->whereDate('device_time', '<=', $search_to_date);
            }
        }
        $mainbatterydisconnect = $query->get();   
        return DataTables::of($mainbatterydisconnect)
        ->addIndexColumn()
        ->addColumn('location', function ($mainbatterydisconnect) {
            $latitude= $mainbatterydisconnect->latitude;
            $longitude=$mainbatterydisconnect->longitude;          
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
        ->addColumn('action', function ($mainbatterydisconnect) {  
        $b_url = \URL::to('/');             
            return "
            <a href=".$b_url."/alert/report/".Crypt::encrypt($mainbatterydisconnect->id)."/mapview class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    } 
    public function export(Request $request)
    {
       return Excel::download(new MainBatteryDisconnectReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'Main-Battery-Disconnect-report.xlsx');
    } 
}