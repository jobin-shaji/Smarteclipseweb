<?php


namespace App\Modules\Route\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Route\Models\RouteArea;
use App\Modules\Vehicle\Models\VehicleRoute;
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
                    'name',
                    'deleted_at'
                    )
            ->withTrashed()
            ->where('client_id',$client_id)
            ->get();
        return DataTables::of($route)
            ->addIndexColumn()
            ->addColumn('action', function ($route) {
                if($route->deleted_at == null){
                    return "
                     <a href=/route/".Crypt::encrypt($route->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> </a>

                    <button onclick=deleteRoute(".$route->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i></button>"; 
                }else{
                     return "
                    <a href=/route/".Crypt::encrypt($route->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> </a>
                    <button onclick=activateRoute(".$route->id.") class='btn btn-xs btn-success'data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> </button>"; 
                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create a new route
    public function createRoute()
    {
        return view('Route::route-add');
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
            ->get()->count();
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
        return DataTables::of($route)
            ->addIndexColumn() 
            ->addColumn('action', function ($route) {                
            return "
             <a href=/route/".Crypt::encrypt($route->route_id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i>View Routes </a>";               
             })
            ->rawColumns(['link', 'action'])         
            ->make();
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
}
