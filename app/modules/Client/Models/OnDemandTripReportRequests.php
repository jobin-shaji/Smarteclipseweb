<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon AS Carbon;


  
class OnDemandTripReportRequests extends Model
{
    protected $fillable=[
		'client_id','vehicle_id','gps_id','trip_report_date','job_submitted_on','report_type',''
    ];
    
    public function createNewTripRequest($clientid,$vehicle_id,$gps_id,$trip_report_date)
    {
    
    $current_date = Carbon::now()->format('Y-m-d H:i:s');
    
    return self::create([
      'client_id'        => $clientid,
      'vehicle_id'       => $vehicle_id ,
      'gps_id'           => $gps_id,
      'trip_report_date' => $trip_report_date,
      'job_submitted_on' => $current_date,
      'report_type'      => "General",
    ]);
  }
  public function vehicle()
  {
    return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id')->withTrashed();
  }
   
  public function getPendingReportRequests()
  {
    return self::orWhereNull('job_attended_on')->get();
  }


}
