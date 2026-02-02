<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ServicerJob extends Model
{
	 use SoftDeletes;

	 protected $fillable = [
        'servicer_id', 'client_id','complaint_id','job_id','start_code','job_type','user_id','description','job_date','job_complete_date','status','latitude','longitude','gps_id','comment','location','role','job_status','reinstallation_vehicle_id'
    ];
    public function user()
	  {
	    return $this->belongsTo('App\Modules\User\Models\User','user_id','id');
	  }
   	public function clients()
   	{
      return $this->hasOne('App\Modules\Client\Models\Client','id','client_id')->withTrashed();
  	}   
  	public function servicer()
   	{
      return $this->hasOne('App\Modules\Servicer\Models\Servicer','id','servicer_id')->withTrashed();
  	} 
    public function gps()
    {
      return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id')->withTrashed();
    }
    public function sub_dealer()
    {
      return $this->hasOne('App\Modules\SubDealer\Models\SubDealer','user_id','user_id');
    }
    // added line
     public function trader()
    {
      return $this->hasOne('App\Modules\Trader\Models\Trader','user_id','user_id');
    }
     public function vehicle()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','gps_id','gps_id')->withTrashed();
    }  
    public function reinstallationVehicle()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','reinstallation_vehicle_id')->withTrashed();
    } 
    public function vehicleGps()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\VehicleGps','servicer_job_id','id');
    } 
    public function vehicleGpsWithGpsId()
    {
      return $this->hasOne('App\Modules\Vehicle\Models\VehicleGps','gps_id','gps_id');
    }  
    public function getNewInstallationList($key = null)
    {
      $user_id=\Auth::user()->servicer->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date','servicer_jobs.status',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('servicer_id',$user_id)
        ->where('job_type',1)
        ->whereNull('job_complete_date')
        ->where('servicer_jobs.status',1);
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  
    public function getOnProgressInstallationList($key = null)
    {
      $user_id=\Auth::user()->servicer->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('servicer_id',$user_id)
        ->where('job_type',1)
        ->where('servicer_jobs.status',2)
        ->whereNull('job_complete_date');
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  
    public function getCompletedInstallationList($key = null)
    {

      $user_id=\Auth::user()->servicer->id;
      
      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->join('vehicle_gps', 'servicer_jobs.id', '=', 'vehicle_gps.servicer_job_id')
        ->join('vehicles', 'vehicle_gps.vehicle_id', '=', 'vehicles.id')
        ->where('servicer_jobs.servicer_id',$user_id)
        ->where('servicer_jobs.status',3)
        ->whereNull('servicer_jobs.deleted_at')
        ->whereNotNull('servicer_jobs.job_complete_date')
        ->orderBy('servicer_jobs.job_complete_date','desc')
        ->where('servicer_jobs.job_type',1)
        ->select('servicer_jobs.id','servicer_jobs.job_complete_date','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.job_type','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date',
        'gps.serial_no as gps_serial_no','clients.address as client_address','vehicles.register_number as register_number');
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('vehicles.register_number','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
      return $query->paginate(10);
    }  
    public function getNewServiceList($key = null)
    {
      $user_id=\Auth::user()->servicer->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date','servicer_jobs.status','servicer_jobs.job_type',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('servicer_id',$user_id)
        ->where('job_type',2)
        ->whereNull('job_complete_date')
        ->where('servicer_jobs.status',1);
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  
    public function getOnProgressServiceList($key = null)
    {
      $user_id=\Auth::user()->servicer->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date','servicer_jobs.status','servicer_jobs.job_type',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('servicer_id',$user_id)
        ->where('job_type',2)
        ->whereNull('job_complete_date')
        ->where('servicer_jobs.status',2);
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  
    public function getCompletedServiceList($key = null)
    {
            $user_id=\Auth::user()->servicer->id;
            $query = DB::table('servicer_jobs')
            ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
            ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
            ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
            ->join('vehicle_gps', 'servicer_jobs.gps_id', '=', 'vehicle_gps.gps_id')
            ->join('vehicles', 'vehicle_gps.vehicle_id', '=', 'vehicles.id')
            ->select('servicer_jobs.id','servicer_jobs.job_complete_date','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
            'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
            'servicer_jobs.description','servicer_jobs.job_type','servicer_jobs.location','servicer_jobs.status',
            'servicer_jobs.job_date',
            'gps.serial_no as gps_serial_no','clients.address as client_address','vehicles.register_number as register_number')
            ->where('servicer_id',$user_id)
            ->where('servicer_jobs.status',3)
            ->whereNotNull('servicer_jobs.job_complete_date')
            ->orderBy('servicer_jobs.job_complete_date','desc')
            ->where('job_type',2);
            
            if( $key != null )
            {
                $query->where(function($query) use($key){
              
                    $query = $query->where('clients.name','like','%'.$key.'%')
                    ->orWhere('gps.serial_no','like','%'.$key.'%')
                    ->orWhere('vehicles.register_number','like','%'.$key.'%')
                    ->orWhere('users.mobile','like','%'.$key.'%')
                    ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
                    ->orWhere('users.email','like','%'.$key.'%');
              });       
            }
                return $query->paginate(10);
        } 
       
    public function getNewInstallationJobCount($servicer_id)
    {
 
        return self::select('job_complete_date')
              ->whereNull('job_complete_date')
              ->where('servicer_id',$servicer_id)->where('job_type',1)
              ->where('status',1)->count();
    } 
    public function getOnProgressJobCount($servicer_id)
    {
      return self::select('id','status','job_complete_date')->whereNull('job_complete_date')
      ->where('servicer_id',$servicer_id)->where('status',2)->where('job_type',1)->count();

    } 
    public function getCompletedJobCount($servicer_id)
    {
      return self::select(
        'job_complete_date',
        'servicer_id',
        'job_type',
        'status',
        'deleted_at'
    )
    ->whereNotNull('job_complete_date')
    ->whereNull('deleted_at')
    ->where('servicer_id',$servicer_id)
    ->where('job_type',1)
    ->where('status',3)
    ->count();
      

    } 
    public function getPendingServiceJobCount($servicer_id)
    {
       return self::select('id','job_complete_date','servicer_id','job_type')->whereNull('job_complete_date')->where('servicer_id',$servicer_id)->where('job_type',2)->where('status',1)->count();
    } 
    public function getProgressServiceJobCount($servicer_id)
    {
       return  self::select('id','job_date','job_complete_date','servicer_id')->whereNull('job_complete_date')->where('servicer_id',$servicer_id)->where('job_type',2)->where('status',2)->count();
    } 
    public function getCompletedServiceJobCount($servicer_id)
    {
       return  self::select('job_complete_date','servicer_id','job_type','status')->whereNotNull('job_complete_date')->where('servicer_id',$servicer_id)->where('job_type',2)->where('status',3)->count();
    } 
    public function getServicerJob($servicer_id)
    {
      return self::find($servicer_id);
    } 
    public function getInstallationJob($servicerjob_id = null)
    {
        return self::find($servicerjob_id);
    }
    public function getNewClientServiceList($key = null)
    {
      $client_id=\Auth::user()->client->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name','servicer_jobs.start_code','servicer_jobs.completion_code','servicer_jobs.comment',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number','servicers.name as servicer_name' ,
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date','servicer_jobs.status','servicer_jobs.job_type',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('client_id',$client_id)
        ->where('job_type',2)
        ->whereNull('job_complete_date');
        // ->where('servicer_jobs.status',1);
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  

    public function getNewReInstallationJobCount($servicer_id)
    {
      return self::select('job_complete_date')
                  ->whereNull('job_complete_date')
                  ->where('servicer_id',$servicer_id)
                  ->where('job_type',3)
                  ->where('status',1)
                  ->count();
    } 
  
    public function getOnProgressReInstallationJobCount($servicer_id)
    {
      return self::select('id','status','job_complete_date')
                  ->whereNull('job_complete_date')
                  ->where('servicer_id',$servicer_id)
                  ->where('status',2)
                  ->where('job_type',3)
                  ->count();
    } 
    public function getReInstallationCompletedJobCount($servicer_id)
    {
      return self::select(
                    'job_complete_date',
                    'servicer_id',
                    'job_type',
                    'status'
                  )
                  ->whereNotNull('job_complete_date')
                  ->where('servicer_id',$servicer_id)
                  ->where('job_type',3)
                  ->where('status',3)
                  ->count();
    } 
  
    public function getNewReInstallationList($key = null)
    {
      $user_id=\Auth::user()->servicer->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date','servicer_jobs.status',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('servicer_id',$user_id)
        ->where('job_type',3)
        ->whereNull('job_complete_date')
        ->where('servicer_jobs.status',1);
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  

    public function getOnProgressReinstallationList($key = null)
    {
      $user_id=\Auth::user()->servicer->id;

      $query = DB::table('servicer_jobs')
        ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
        ->join('users', 'users.id', '=', 'clients.user_id')
        ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
        ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
        ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
        ->select('servicer_jobs.id','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
        'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
        'servicer_jobs.description','servicer_jobs.location','servicer_jobs.status',
        'servicer_jobs.job_date',
        'gps.serial_no as gps_serial_no','clients.address as client_address')
        ->where('servicer_id',$user_id)
        ->where('job_type',3)
        ->where('servicer_jobs.status',2)
        ->whereNull('job_complete_date');
        if( $key != null )
        {
          $query->where(function($query) use($key){
            $query = $query->where('clients.name','like','%'.$key.'%')
              ->orWhere('gps.serial_no','like','%'.$key.'%')
              ->orWhere('users.mobile','like','%'.$key.'%')
              ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
              ->orWhere('users.email','like','%'.$key.'%');
          });       
        }
        return $query->paginate(10);
    }  

    public function getCompletedReinstallationList($key = null)
    {

      $user_id=\Auth::user()->servicer->id;
      
      $query = DB::table('servicer_jobs')
          ->join('clients', 'servicer_jobs.client_id', '=', 'clients.id')
          ->join('users', 'users.id', '=', 'clients.user_id')
          ->join('users as servicer_users', 'servicer_users.id', '=', 'servicer_jobs.user_id')
          ->join('servicers', 'servicer_jobs.servicer_id', '=','servicers.id')
          ->join('gps', 'servicer_jobs.gps_id', '=', 'gps.id')
          ->join('vehicle_gps', 'servicer_jobs.id', '=', 'vehicle_gps.servicer_job_id')
          ->join('vehicles', 'vehicle_gps.vehicle_id', '=', 'vehicles.id')
          ->where('servicer_jobs.servicer_id',$user_id)
            ->where('servicer_jobs.status',3)
          ->whereNotNull('servicer_jobs.job_complete_date')
          ->orderBy('servicer_jobs.job_complete_date','desc')
            ->where('servicer_jobs.job_type',3)
            ->select('servicer_jobs.id','servicer_jobs.job_complete_date','servicer_jobs.status','servicer_jobs.job_id','clients.name as client_name',
          'servicer_users.username as user_name','users.email as user_email','users.mobile as mobile_number', 
          'servicer_jobs.description','servicer_jobs.job_type','servicer_jobs.location','servicer_jobs.status',
          'servicer_jobs.job_date',
          'gps.serial_no as gps_serial_no','clients.address as client_address','vehicles.register_number as register_number');
          if( $key != null )
          {
            $query->where(function($query) use($key){
              $query = $query->where('clients.name','like','%'.$key.'%')
                            ->orWhere('gps.serial_no','like','%'.$key.'%')
                            ->orWhere('vehicles.register_number','like','%'.$key.'%')
                            ->orWhere('users.mobile','like','%'.$key.'%')
                            ->orWhere('servicer_jobs.job_id','like','%'.$key.'%')
                            ->orWhere('users.email','like','%'.$key.'%');
            });       
          }
      return $query->paginate(10);
    }  

    public function checkUncompleteRepeatedJobForGps($gps_id)
    {
      return self::where('gps_id',$gps_id)
                  ->where('job_type',[1,3])
                  ->whereNull('job_complete_date')
                  ->count();
    }

    /**
     * 
     * 
     */
    public function getInstallationBasedOnGps($gps_id)
    {
      return self::select('servicer_id','job_date','job_complete_date','status','location','description','comment')
                  ->where('gps_id',$gps_id)
                  ->where('job_type', 1)
                  ->with('servicer')
                  ->with('servicer.user')
                  ->first();
    }

    /**
     * 
     * 
     */
    public function getServiceDetailsBasedOnGps($gps_id)
    {
      return self::select('servicer_id','job_date','job_complete_date','status','location','description','comment')
                  ->where('gps_id',$gps_id)
                  ->where('job_type', 2)
                  ->with('servicer')
                  ->with('servicer.user')
                  ->orderBy('job_date','desc')
                  ->get();
    }

}

