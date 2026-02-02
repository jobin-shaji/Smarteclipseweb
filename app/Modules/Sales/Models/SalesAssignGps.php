<?php

namespace App\Modules\Sales\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesAssignGps extends Model
{
    use SoftDeletes;   
    public $table = 'sales_imei_assign'; 
	protected $fillable=[
		'callcenter_id','gps_id','assigned_by','status'
    ];
    public function callcenter()
    {
      return $this->belongsTo(Callcenter::class, 'callcenter_id')->withTrashed();

    //	return $this->belongsTo('App\Modules\Sales\Models\Callcenters','callcenter_id','id');
     }
     
  
  /**
   * getSalesmanDetails
   */
  
   /**
   * root id
   */
  public function gps()
  {
    return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
  }

}
