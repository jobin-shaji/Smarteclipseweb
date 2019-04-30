<?php

namespace App\Modules\User\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address','user_id','sub_dealer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //state of a user 
    public function state()
    {
        return $this->hasOne('App\Modules\Depot\Models\State','id','state_id');
    }

    //depot of a user 
    public function depot()
    {
       return $this->belongsToMany('\App\Modules\Depot\Models\Depot','depot_users','user_id','depot_id');
    }
}
