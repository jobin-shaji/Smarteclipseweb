<?php

namespace App\Modules\Monitoring\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\Route\Models\Route;
use App\Modules\User\Models\User;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Vehicle\Models\VehicleDriverLog;
use App\Modules\Vehicle\Models\Document;
use App\Modules\Driver\Models\Driver;
use App\Modules\Gps\Models\Gps;
use App\Modules\Client\Models\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Modules\Operations\Models\VehicleModels;
use App\Http\Traits\VehicleDataProcessorTrait;
use Carbon\Carbon;
use DataTables;
use Config;

class MonitorController extends Controller 
{
    /** 
     * Response data 
     */
    private $data;

    /**
     * Http response code
     */
    private $code;

    /**
     * Response status
     */
    private $success;

    /**
     * Response message
     */
    private $message;

    /**
     * Init class attributes
     */
    public function __construct()
    {
        $this->data     = [];
        $this->code     = Response::HTTP_OK;
        $this->success  = true;
        $this->message  = '';
    }

    public function dashboard()
    {
        return view('Monitoring::monitor'); 
    }


    /**
     * 
     * 
     */
    public function getVehicleList(Request $request)
    {
        $key = ( isset($request->monitoring_module_search_key) ) ? $request->monitoring_module_search_key : null;
        return view('Monitoring::vehiclelist',['vehicles'=> (new Vehicle())->getVehicleList($key)]); 
    }

    public function getVehicleAlertData(Request $request)
    {

        return view('Monitoring::vehiclelist',['alerts'=> (new Vehicle())->getAlertList(),'vehicles'=> null]); 
    }

    /**
     * 
     * 
     */
    public function filterVehicleList(Request $request)
    {
       return view('Monitoring::vehiclelist',['vehicles'=> (new Vehicle())->getVehicleList($request)]); 
    }
    
    /**
     * 
     * 
     */
    public function getVehicleData(Request $request)
    {
        try
        {
            if( !isset($request->vehicle_id) )
            {
                throw new \Exception('Missing vehicle id');
            }

            $this->data = (new Vehicle())->getVehicleDetails($request->vehicle_id);
            return response()->json([ 'data' => $this->data, 'success' => $this->success, 'message' => $this->message ], $this->code);   
        }
        catch(\Exception $e)
        {
            $this->success = false;
            $this->message = 'failed';
            return response()->json([ 'data' => $this->data, 'success' => $this->success, 'message' => $this->message  ], $this->code);
        }  
    }

    public function getEmergencyalerts()
    {

     try
        {
            $this->alert = (new Gps())->getEmergencyalerts();
            return response()->json([ 'data' => $this->alert, 'success' => $this->success, 'message' => $this->message ], $this->code);   
        }
        catch(\Exception $e)
        {
            $this->success = false;
            $this->message = 'failed';
            return response()->json([ 'data' => $this->alert, 'success' => $this->success, 'message' => $this->message  ]);
        }  
        
    }

    public function getAlertMap()
    {
       return view('Monitoring::map-monitoring',['alerts'=> (new Vehicle())->getAlertList(),'vehicles'=> null]);  
    }
    
    
}
