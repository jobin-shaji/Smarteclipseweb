<?php

namespace App\Modules\Servicer\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class ServicerJob extends Model
{
	 use SoftDeletes;

	 protected $fillable = [
        'servicer_id', 'client_id','job_id','job_type','user_id','description','job_date','job_complete_date','status','latitude','longitude','gps_id','comment','location'
    ];
    public function user()
	  {
	    return $this->belongsTo('App\Modules\User\Models\User','user_id','id');
	  }
   	public function clients()
   	{
      return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
  	}   
  	public function servicer()
   	{
      return $this->hasOne('App\Modules\Servicer\Models\Servicer','id','servicer_id');
  	} 
    public function gps()
    {
      return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    public function sub_dealer()
    {
      return $this->hasOne('App\Modules\SubDealer\Models\SubDealer','user_id','user_id');
    }  
}
