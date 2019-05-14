<?php

namespace App\Modules\Geofence\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Geofence extends Model
{
	use SoftDeletes;    

	protected $fillable=[
		'user_id','name','fence_type_id'
	];

	protected $casts = [
        'cordinates' => 'array'
    ];
    	public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id');
    }

     public function clients(){
      return $this->hasOne('App\Modules\Client\Models\Client','user_id','user_id');
  }
	
}
