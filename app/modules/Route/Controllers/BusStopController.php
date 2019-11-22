<?php


namespace App\Modules\Route\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Client\Models\Client;
use App\Modules\Route\Models\BusStop;
use App\Modules\Route\Models\RouteSchedule;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\RouteBatch\Models\RouteBatch;
use App\Modules\BusHelper\Models\BusHelper;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use DataTables;

class BusStopController extends Controller {
    
    // create new bus stop
    public function createBusStop()
    {
        $client_id=\Auth::user()->client->id;
        $routes=Route::where('client_id',$client_id)->get();
        return view('Route::bus-stop-add',['routes' => $routes]);
    }

    //upload bus stop details to database table
    public function saveBusStop(Request $request)
    {
        $client_id = \Auth::user()->client->id;    
        $rules = $this->busStopCreateRules();
        $this->validate($request, $rules);  
        $location_lat=$request->latitude;
        $location_lng=$request->longitude; 
        if($location_lat==null){
            $placeLatLng=$this->getPlaceLatLng($request->stop_location); 
            if($placeLatLng==null){
                  $request->session()->flash('message', 'Enter correct location'); 
                  $request->session()->flash('alert-class', 'alert-danger'); 
                  return redirect(route('bus-stop.create'));        
            }
            $location_lat=$placeLatLng['latitude'];
            $location_lng=$placeLatLng['longitude'];  
        }   
        $bus_stop = BusStop::create([          
            'name' => $request->name,  
            'route_id' => $request->route_id, 
            'latitude' => $location_lat,
            'longitude' => $location_lng,   
            'client_id' => $client_id,  
        ]);
        $request->session()->flash('message', 'New bus stop created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('bus-stop'));        
    }

    //Student list
    public function busStopList()
    {
        return view('Route::bus-stop-list');
    }

    public function getBusStopList(Request $request)
    {
    	$client_id = \Auth::user()->client->id; 
        $bus_stop = BusStop::select(
            'id', 
            'name',  
            'route_id',                  
            'deleted_at')
            ->withTrashed()
            ->with('route:id,name')
            ->where('client_id',$client_id)
            ->get();
            return DataTables::of($bus_stop)
            ->addIndexColumn()
            ->addColumn('action', function ($bus_stop) {
                 $b_url = \URL::to('/');
            if($bus_stop->deleted_at == null){ 
                return "
                <button onclick=delBusStop(".$bus_stop->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'> Deactivate</button>
                <a href=".$b_url."/bus-stop/".Crypt::encrypt($bus_stop->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'> View</a>
                <a href=".$b_url."/bus-stop/".Crypt::encrypt($bus_stop->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'> Edit </a>
                ";
            }else{                   
                return "
                <button onclick=activateBusStop(".$bus_stop->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // view page
    public function viewBusStop(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $bus_stop=BusStop::find($decrypted_id);
        $latitude= $bus_stop->latitude;
        $longitude=$bus_stop->longitude;          
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
            $output = json_decode($geocodeFromLatLong);         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude            
            $location=$address;
        }
        else
        {
              $location="";
        }
        if($bus_stop==null){
            return view('Route::404');
        } 
        return view('Route::bus-stop-view',['bus_stop' => $bus_stop,'location' => $location]);
    }

    //EDIT BUS STOP DETAILS
    public function editBusStop(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $bus_stop = BusStop::find($decrypted);
        $latitude= $bus_stop->latitude;
        $longitude=$bus_stop->longitude;          
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
            $output = json_decode($geocodeFromLatLong);         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude            
            $location=$address;
        }
        else
        {
              $location="";
        }
        $client_id = \Auth::user()->client->id;
        $routes=Route::select('id','name')
                ->where('client_id',$client_id)
                ->get();      
        if($bus_stop == null)
        {
           return view('Route::404');
        }
        return view('Route::bus-stop-edit',['bus_stop' => $bus_stop,'location' => $location,'routes' => $routes]);
    }

    //update bus stop details
    public function updateBusStop(Request $request)
    {
        $bus_stop = BusStop::where('id', $request->id)->first();
        $did = encrypt($bus_stop->id);
        if($bus_stop == null){
           return view('Route::404');
        } 
        $rules = $this->busStopUpdateRules($bus_stop);
        $this->validate($request, $rules);  
        $location_lat=$request->latitude;
        $location_lng=$request->longitude;  
        if($location_lat==null){
            $placeLatLng=$this->getPlaceLatLng($request->stop_location); 
            if($placeLatLng==null){
                  $request->session()->flash('message', 'Enter correct location'); 
                  $request->session()->flash('alert-class', 'alert-danger'); 
                  return redirect(route('bus-stop.edit',$did));        
            }
            $location_lat=$placeLatLng['latitude'];
            $location_lng=$placeLatLng['longitude'];  
        }
        $bus_stop->latitude= $location_lat;
        $bus_stop->longitude=$location_lng;
        $bus_stop->route_id = $request->route_id;     
        $bus_stop->name = $request->name;
        $bus_stop->save();      
        $did = encrypt($bus_stop->id);
        $request->session()->flash('message', 'Bus stop details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('bus-stop.edit',$did));  
    }

    //deactivated bus stop details from table
    public function deleteBusStop(Request $request)
    {
        $bus_stop = BusStop::find($request->id);
        if($bus_stop == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Bus stop does not exist'
            ]);
        }
        $bus_stop->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Bus stop deleted successfully'
        ]);
    }


    // restore bus stop
    public function activateBusStop(Request $request)
    {
        $bus_stop = BusStop::withTrashed()->find($request->id);
        if($bus_stop==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Bus stop does not exist'
             ]);
        }

        $bus_stop->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Bus stop restored successfully'
        ]);
    }

/////////////////////////////PLACE NAME//////////////////////////////////////
    function getPlaceLatLng($address){

        $data = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $data . "&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo";
        $geocode_stats = file_get_contents($url);
        $output_deals = json_decode($geocode_stats);
        if ($output_deals->status != "OK") {
            return null;
        }
        if ($output_deals) {
            $latLng = $output_deals->results[0]->geometry->location;
            $lat = $latLng->lat;
            $lng = $latLng->lng;
            $locationData = ["latitude" => $lat, "longitude" => $lng];
            return $locationData;
        } else {
            return null;
        }
    }

////////////////////////////////////////////////////////////////////////////

    public function busStopCreateRules()
    {
        $rules = [
            'name' => 'required|unique:bus_stops',
            'route_id' => 'required',
            'stop_location' => 'required'
            
        ];
        return  $rules;
    }

    //validation for bus stop  updation
    public function busStopUpdateRules($bus_stop)
    {
        $rules = [
            'name' => 'required|unique:bus_stops,name,'.$bus_stop->id,
            'route_id' => 'required',
            'stop_location' => 'required',
            
        ];
        return  $rules;
    }

}
