<?php


namespace App\Modules\Route\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Client\Models\Client;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Route\Models\RouteSchedule;
use App\Modules\Vehicle\Models\VehicleRoute;
use App\Modules\RouteBatch\Models\RouteBatch;
use App\Modules\BusHelper\Models\BusHelper;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use DataTables;

class RouteController extends Controller {
    
    // show list page
    public function routeList()
    {
       return view('Route::route-list'); 
    }

    // data for list page
    public function getRouteList()
    {
        $client_id=\Auth::user()->client->id;
        $route = Route::select(
                    'id',
                    'name'
        )
        ->where('client_id',$client_id)
        ->get();
        return DataTables::of($route)
        ->addIndexColumn()
        ->addColumn('action', function ($route) {
            $b_url = \URL::to('/'); 
            
                return "
                 <a href=".$b_url."/route/".Crypt::encrypt($route->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>                
                <button onclick=deleteRoute(".$route->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Delete</button>";             
         })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create a new route
    public function createRoute(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $driver_location=Client::select('latitude','longitude')
                ->where('id',$client_id)
                ->first();
        $Route = Route::select(
            'id', 
            'client_id'                                  
        )  
        ->where('client_id',$client_id)        
        ->count(); 
        if($Route<2){

           return view('Route::route-add',['driver_location' => $driver_location]);
        }else if($request->user()->hasRole('fundamental')&& $Route<4) {
           return view('Route::route-add',['driver_location' => $driver_location]);
        }
        else if($request->user()->hasRole('superior')&& $Route<8) {
           return view('Route::route-add',['driver_location' => $driver_location]);
        }
        else if($request->user()->hasRole('pro')&& $Route<10) {
            return view('Route::route-add',['driver_location' => $driver_location]);
        }
        else if($request->user()->hasRole('pro')&& $Route==10) {
            $request->session()->flash('message', 'exceed the limit'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('route'));  
        }
        else{           
            $request->session()->flash('message', 'Please upgrade your current plan for adding more Route'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('route'));           
        }
      
    }

    // // save route
    public function saveRoute(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $rules = $this->routeCreateRules();
        $this->validate($request, $rules);
        $route_name=$request->name;
        $route_points=$request->points;
        $removed_last_comma_points=substr($route_points, 0, -1);
        $point_split=explode(";",$removed_last_comma_points);
        $route = Route::create([
            'name' => $request->name,
            'client_id' => $client_id
        ]);
        if($route){
            foreach ($point_split as $point){
                $route_point_remove_brackets=trim($point,'(,)');
                $route_point_imploaded=explode(",",$route_point_remove_brackets);
                $route_point_lat=$route_point_imploaded[0];
                $route_point_lng=$route_point_imploaded[1];

                $route_area = RouteArea::create([
                    'route_id' => $route->id,
                    'latitude' => $route_point_lat,
                    'longitude' => $route_point_lng
                ]);
            }
        }
        $request->session()->flash('message', 'New Route created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('route'));
    }
    
    // // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $route=Route::find($decrypted_id);
        if($route==null){
            return view('Route::404');
        } 
        $route_area=RouteArea::select('route_id','latitude','longitude')
                                        ->where('route_id',$decrypted_id)
                                        ->get();
        return view('Route::route-details',['route' => $route,'route_area' => $route_area]);
    }

    // Route delete
    public function deleteRoute(Request $request)
    {
        $route=Route::find($request->id);
        if($route == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Route does not exist'
            ]);
        }
        $route->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Route deleted successfully'
        ]);
     }


    // restore route
    public function activateRoute(Request $request)
    {       
        $route = Route::withTrashed()->find($request->id);
        if($route==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Route does not exist'
             ]);
        }
        $route->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Route restored successfully'
        ]);
    }

    // assign route list
    public function AssignRouteList()
    {
        $client_id=\Auth::user()->client->id;
        $vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        $routes=Route::select('id','name','client_id')
        ->where('client_id',$client_id)
        ->get();
         return view('Route::assign-route-vehicle-list',['vehicles'=>$vehicles,'routes'=>$routes]); 
    }




    public function getAssignRouteVehicleList(Request $request)
    {
        $client_id=\Auth::user()->client->id;
       // $client_id= $request->client;         
        $vehicle_id= $request->vehicle_id;           
        $routes = $request->route_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $fromDate = date("Y-m-d", strtotime($from_date));
        $toDate = date("Y-m-d", strtotime($to_date));
        if($vehicle_id!="")
         {
            $router = VehicleRoute::select('id','vehicle_id','route_id','date_from','date_to')
            ->where('vehicle_id',$vehicle_id)
            ->where('route_id',$routes)
            ->where('client_id',$client_id)
             ->whereBetween('date_from',array($fromDate,$toDate))
            ->WhereBetween('date_to',array($fromDate,$toDate))
            ->get()->count();
// dd($router);
            if($router==0)
            {
                 $route_area = VehicleRoute::create([
                        'route_id' => $routes,
                        'vehicle_id' => $vehicle_id,
                        'date_from' => $fromDate,
                        'date_to' => $toDate,
                        'client_id' => $client_id,
                        'status' => 1
                    ]);
            } 
            else{
                // $request->session()->flash('message', 'Already Assigned Route!'); 
                // $request->session()->flash('alert-class', 'alert-success'); 
                // return redirect(route('route'));

            }  
        }     
        $route = VehicleRoute::select(
                    'id',
                    'vehicle_id',
                    'route_id',
                    'date_from',
                     'date_to'                                      
                    )
        ->with('vehicleRoute:id,name')
       ->with('vehicle:id,name,register_number')
        ->where('client_id',$client_id)
        ->get();
        // dd($route);
        return DataTables::of($route)
            ->addIndexColumn() 
            ->addColumn('action', function ($route) { 
            $b_url = \URL::to('/');               
            return "
             <a href=".$b_url."/route/".Crypt::encrypt($route->route_id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i>View Routes </a>";               
             })
            ->rawColumns(['link', 'action'])         
            ->make();
    }
    public function alredyassignroutelist(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $vehicle_id= $request->vehicle_id;           
        $routes = $request->route_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $fromDate = date("Y-m-d", strtotime($from_date));
        $toDate = date("Y-m-d", strtotime($to_date));
        $router = VehicleRoute::select('id','vehicle_id','route_id','date_from','date_to')
        ->where('vehicle_id',$vehicle_id)
        ->where('route_id',$routes)
        ->where('client_id',$client_id)
        ->whereBetween('date_from',array($fromDate,$toDate))
        ->WhereBetween('date_to',array($fromDate,$toDate))
        ->get()->count();
        // dd($router);
        return response()->json([
            'assign_route_count' => $router            
        ]);       
    }

    // route schedule list
    public function routeScheduledList()
    {
       return view('Route::route-schedule-list'); 
    }

    // route schedule list data
    public function getrouteScheduledList()
    {
        $client_id=\Auth::user()->client->id;
        $route_schedule = RouteSchedule::select(
                    'id',
                    'route_batch_id',
                    'route_id',
                    'vehicle_id',
                    'driver_id',
                    'helper_id',
                    'client_id',
                    'deleted_at'
                    )
                ->withTrashed()
                ->with('routeBatch:id,name')
                ->with('route:id,name')
                ->with('vehicle:id,name,register_number')
                ->with('driver:id,name')
                ->with('helper:id,name,helper_code')
                ->where('client_id',$client_id)
                ->get();
        return DataTables::of($route_schedule)
            ->addIndexColumn()
            ->addColumn('action', function ($route_schedule) {
                $b_url = \URL::to('/');
                if($route_schedule->deleted_at ==null){
                    return 
                        "
                        <button onclick=deleteScheduleRoute(".$route_schedule->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                        </button>
                        <a href=".$b_url."/route/".Crypt::encrypt($route_schedule->id)."/schedule-edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                        ";
                }else{
                    return 
                        "<button onclick=activateScheduleRoute(".$route_schedule->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Activate
                        </button>";
                }
                
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // schedule a route and bus
    public function scheduleRoute()
    {
        $client_id=\Auth::user()->client->id;
        $client_user_id=\Auth::user()->id;
        $schedule_vehicles = RouteSchedule::select(
                'vehicle_id',
                'helper_id',
                'route_batch_id'
                )
                ->where('client_id',$client_id)
                ->get();
        $single_vehicle = [];
        $single_helper = [];
        $single_route_batch = [];
        foreach($schedule_vehicles as $vehicle){
            $single_vehicle[] = $vehicle->vehicle_id;
            $single_helper[] = $vehicle->helper_id;
            $single_route_batch[] = $vehicle->route_batch_id;
        }
        $vehicles=Vehicle::select('id','name','register_number')
                ->where('client_id',$client_id)
                ->whereNotIn('id',$single_vehicle)
                ->get();
        $helpers=BusHelper::select('id','helper_code','name')
                ->where('client_id',$client_id)
                ->whereNotIn('id',$single_helper)
                ->get();
        $route_batches=RouteBatch::select('id','name')
                ->where('client_id',$client_id)
                ->whereNotIn('id',$single_route_batch)
                ->get();
        return view('Route::route-schedule',['vehicles' => $vehicles,'helpers' => $helpers,'route_batches' => $route_batches]);
    }

    public function routeBatchData(Request $request){
        $route_batch = RouteBatch::find($request->routeBatchID);
        $route_batch->route;
        return response()->json(array('response' => 'success', 'route_batch' => $route_batch));
    }

    public function routeVehicleDriverData(Request $request){
        $vehicle = Vehicle::find($request->vehicleID);
        $vehicle->driver;
        return response()->json(array('response' => 'success', 'vehicle' => $vehicle));
    }

    // save vehicle schedules
    public function saveScheduleRoute(Request $request)
    {
        $client_id=\Auth::user()->client->id;
        $rules = $this->scheduleRouteCreateRules();
        $this->validate($request, $rules);
        $route_schedule = RouteSchedule::create([
            'route_batch_id' => $request->route_batch_id,
            'route_id' => $request->route_id,
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'helper_id' => $request->helper_id,
            'client_id' => $client_id,
           ]);
        $request->session()->flash('message', ' Route scheduled successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('route.schedule'));
    }

    //edit scheduled route details
    public function editScheduleRoute(Request $request)
    {
        $client_id = \Auth::user()->client->id;
        $decrypted = Crypt::decrypt($request->id); 
        $route_schedule = RouteSchedule::find($decrypted); 
        $schedule_vehicles = RouteSchedule::select(
                'vehicle_id',
                'helper_id',
                'route_batch_id'
                )
                ->where('client_id',$client_id)
                ->whereNotIn('id',[$route_schedule->id])
                ->get();
        $single_vehicle = [];
        $single_helper = [];
        $single_route_batch = [];
        foreach($schedule_vehicles as $vehicle){
            $single_vehicle[] = $vehicle->vehicle_id;
            $single_helper[] = $vehicle->helper_id;
            $single_route_batch[] = $vehicle->route_batch_id;
        }
        $vehicles=Vehicle::select('id','name','register_number')
                ->where('client_id',$client_id)
                ->whereNotIn('id',$single_vehicle)
                ->get();
        $helpers=BusHelper::select('id','helper_code','name')
                ->where('client_id',$client_id)
                ->whereNotIn('id',$single_helper)
                ->get();
        $route_batches=RouteBatch::select('id','name')
                ->where('client_id',$client_id)
                ->whereNotIn('id',$single_route_batch)
                ->get();    
        if($route_schedule == null)
        {
           return view('Route::404');
        }
        return view('Route::route-schedule-edit',['route_schedule' => $route_schedule,'vehicles' => $vehicles,'helpers' => $helpers,'route_batches' => $route_batches]);
    }

    //update scheduled route details
    public function updateScheduleRoute(Request $request)
    {
        $route_schedule = RouteSchedule::where('id', $request->id)->first();
        if($route_schedule == null){
           return view('Route::404');
        } 
        $rules = $this->routeScheduleUpdateRules($route_schedule);
        $this->validate($request, $rules); 
        $route_schedule->route_batch_id = $request->route_batch_id;      
        $route_schedule->route_id = $request->route_id;
        $route_schedule->vehicle_id = $request->vehicle_id;
        $route_schedule->driver_id = $request->driver_id;
        $route_schedule->helper_id = $request->helper_id;
        $route_schedule->save();      
        $did = encrypt($route_schedule->id);
        $request->session()->flash('message', 'Scheduled route updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('route.schedule-edit',$did));  
    }

    //deactivated scheduled route details from table
    public function deleteScheduleRoute(Request $request)
    {
        $route_schedule = RouteSchedule::find($request->uid);
        if($route_schedule == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'division does not exist'
            ]);
        }
        $route_schedule->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Scheduled route deactivated successfully'
        ]);
    }

    // restore scheduled route
    public function activateScheduleRoute(Request $request)
    {
        $route_schedule = RouteSchedule::withTrashed()->find($request->id);
        if($route_schedule==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'division does not exist'
             ]);
        }

        $route_schedule->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Scheduled route activated successfully'
        ]);
    }


    //////////////////////////////////////RULES/////////////////////////////
    //route create rules
    public function routeCreateRules()
    {
        $rules = [
            'name' => 'required|unique:routes'
        ];
        return  $rules;
    }

    public function scheduleRouteCreateRules()
    {
        $rules = [
            'route_batch_id' => 'required',
            'route_id' => 'required',
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'helper_id' => 'required',
        ];
        return  $rules;
    }

    public function routeScheduleUpdateRules($route_schedule)
    {
        $rules = [
            'route_batch_id' => 'required',
            'route_id' => 'required',
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'helper_id' => 'required',
        ];
        return  $rules;
    }
}
