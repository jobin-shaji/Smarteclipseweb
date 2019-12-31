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
   
    public function getVehicleList()
    {
        
        $vehicles = Vehicle::select(
                    'id',
                    'name',
                    'servicer_job_id',
                    'gps_id',
                    

                    )
             ->with('gps')
             ->with('servicerjob')
            ->paginate(10);
            // dd($vehicles);
            return view('Monitoring::vehiclelist',['vehicles'=>$vehicles]); 
    }
}
