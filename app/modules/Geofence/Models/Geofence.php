<?php

namespace App\Modules\Geofence\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Geofence extends Model
{
  public $timestamps = false;

	use SoftDeletes;    

	protected $fillable=[
		'user_id','cordinates','response','code','name','created_at','updated_at'
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
