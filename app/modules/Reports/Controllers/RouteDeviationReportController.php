<?php
namespace App\Modules\Reports\Controllers;
use App\Exports\RouteDeviationReportExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Modules\Route\Models\RouteDeviation;
use App\Modules\Vehicle\Models\Vehicle;
use DataTables;
class RouteDeviationReportController extends Controller
{
    public function routeDeviationReport()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::route-deviation-report',['vehicles'=>$vehicles]);  
    }  
    public function routeDeviationReportList(Request $request)
    {
        $client_id=\Auth::user()->client->id;;
        $from = $request->data['from_date'];
        $to = $request->data['to_date'];
        $vehicle = $request->data['vehicle'];
        // dd($vehicle);
        if($vehicle== null || $vehicle==0)
        {
            $query =RouteDeviation::select(
                'id',
                'vehicle_id', 
                'route_id',    
                'latitude',
                'longitude',
                'deviating_time',
                'created_at'
            )
            ->with('vehicle:id,name,register_number')
            ->with('route:id,name')       
            ->where('client_id',$client_id);
        }
        else
        {
            $query =RouteDeviation::select(
                'id',
                'vehicle_id', 
                'route_id',    
                'latitude',
                'longitude',
                'deviating_time',
                'created_at'
            )
            ->with('vehicle:id,name,register_number')
            ->with('route:id,name')
            ->where('vehicle_id',$vehicle)       
            ->where('client_id',$client_id);  
        }
        
        if($from){
            $query = $query->whereBetween('deviating_time',[$from,$to]);
        }
        $route_deviation = $query->get(); 
        // dd($route_deviation);     
        return DataTables::of($route_deviation)
        ->addIndexColumn()
         ->addColumn('location', function ($route_deviation) {
         $latitude= $route_deviation->latitude;
         $longitude=$route_deviation->longitude;          
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
        ->make();
    }
    public function export(Request $request)
    {
       return Excel::download(new RouteDeviationReportExport($request->id,$request->vehicle,$request->fromDate,$request->toDate), 'route-deviation-report.xlsx');
    }
}