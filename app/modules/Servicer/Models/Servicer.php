<?php

namespace App\Modules\Servicer\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Servicer extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address','status','type','user_id','sub_dealer_id'
    ];

    public function user()
  	{
    	return $this->belongsTo('App\Modules\User\Models\User')->withTrashed();
  	}


}
