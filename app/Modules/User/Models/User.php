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
        'name', 'email','mobile', 'password','username','status','state_id','role_id','profile_pic'
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

    public function trader()
    {
        return $this->hasone('App\Modules\Trader\Models\Trader','user_id','id');

    } 

    public function client()
    {
        return $this->hasone('App\Modules\Client\Models\Client','user_id','id');
    }

    public function servicer()
    {
        return $this->hasone('App\Modules\Servicer\Models\Servicer','user_id','id');
    }

    public function finance()
    {
        return $this->hasone('App\Modules\Sales\Models\Finance','user_id','id');
    }

    public function dealercount()
    {
        return $this->hasMany('App\Modules\Dealer\Models\Dealer','root_id','id');
    } 

    public function geofence()
    {
        return $this->hasone('App\Modules\Geofence\Models\Geofence','user_id','id');
    }

    public function operations()
    {
        return $this->hasone('App\Modules\Operations\Models\Operations','user_id','id');
    }

    public function stores()
    {
        return $this->hasone('App\Modules\Operations\Models\StoreKeeper','user_id','id');
    }
    public function callcenter()
    {
        return $this->hasone('App\Modules\Sales\Models\Callcenter','user_id','id');
    }
    public function salesman()
    {
        return $this->hasone('App\Modules\Sales\Models\Salesman','user_id','id');
    }

    public function driver()
    {
        return $this->hasone('App\Modules\Driver\Models\Driver','user_id','id');
    }
    public function employee()
    {
        return $this->hasone('App\Modules\Employee\Models\Employee','user_id','id');
    }
    
    /**
     * 
     * 
     */
    public function getUserRoleDetailsOfAllClients($client_user_ids, $download_type = null, $plan_type = null)
    {
        $query = self::select('id','role')
                ->whereIn('id', $client_user_ids)
                ->with('client');
        ( $plan_type == null ) ? $query : $query->where('role', $plan_type);
        if( $download_type == null)
        {
            return $query->paginate(10);
        }
        else
        {
            return $query->get();
        }
    }

    /**
     * 
     * 
     */
    public function getCountOfClientsUnderPlan($client_user_ids, $plan_type)
    {
        return $query = self::select('id')->whereIn('id', $client_user_ids)->where('role', $plan_type)->count();
    }
}
