<?php
namespace  App\Modules\TripReport\Models;
use Illuminate\Database\Eloquent\Model;

class TripReportConfiguration extends Model
{
    protected $fillable=[
		'plan_id','number_of_report_per_month','backup_days','free_vehicle'
    ];	
    
    public function getListConfiguration()
    {
     return self::select('id','plan_id','number_of_report_per_month','backup_days','free_vehicle')->get();
    }

    public function updateConfiguration($request)
    {
      return self::where('id',$request->plan_id)
      ->update([
        'number_of_report_per_month' => $request->number_of_reports,
        'backup_days'                => $request->backup_days,
        'free_vehicle'               => $request->free_vehicle      
      ]);

    }
    
}
