<?php

namespace App\Modules\User\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','mobile', 'password','username','status','state_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function root()
    {
        return $this->hasone('App\Modules\Root\Models\Root','user_id','id');
    } 

    public function dealer()
    {
        return $this->hasone('App\Modules\Dealer\Models\Dealer','user_id','id');
    } 

    public function subdealer()
    {
        return $this->hasone('App\Modules\SubDealer\Models\SubDealer','user_id','id');
    } 

    public function client()
    {
        return $this->hasone('App\Modules\Client\Models\Client','user_id','id');
    }
     public function servicer()
    {
        return $this->hasone('App\Modules\Servicer\Models\Servicer','user_id','id');
    }


    public function dealercount()
    {
        return $this->hasMany('App\Modules\Dealer\Models\Dealer','root_id','id');
    } 
}
