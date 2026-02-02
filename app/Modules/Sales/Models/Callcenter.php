<?php

namespace App\Modules\Sales\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Callcenter extends Model
{
    use SoftDeletes;   

    protected $table = 'call_centers'; 

    protected $fillable = [
        'user_id',
        'sales_id',
        'name',
        'address',
        'code'
    ];
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id')->withTrashed();
    }

    public function assign()
    {
      return $this->belongsTo('App\Modules\Sales\Models\SalesAssignGps','callcenter_id','id')->withTrashed();
    }
  
  /**
   * getSalesmanDetails
   */
  public function getCallmanDetails($salesman_id)
	{
		return self::select('id','name','root_id')->where('id',$salesman_id)->with('root')->first();
  }
   /**
   * root id
   */
  public function sales()
  {
    return $this->hasOne('App\Modules\Root\Models\Salesman','id','sales_id');
  }

}
