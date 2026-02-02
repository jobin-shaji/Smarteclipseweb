<?php

namespace App\Modules\Sales\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GpsFollowup extends Model
{
    use SoftDeletes;   
    public $table = 'gps_followup'; 
	protected $fillable=[
		'user_id','gps_id','status','description','next_follow_date'
    ];
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id')->withTrashed();
  }
  public function gps()
  {
      return $this->belongsTo('App\Modules\Gps\Models\Gps','gps_id','id')->withTrashed();
}
  
  

}
