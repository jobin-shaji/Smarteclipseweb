<?php

namespace App\Modules\Sos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Sos extends Model
{
    use SoftDeletes;
 
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'imei','manufacturing_date','brand','model_name','version','user_id','status'];

    //join user table with sos table
    public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id');
    }

    public function transfers()
    {
    	return $this->hasMany('App\Modules\Sos\Models\SosTransfer');
    }

    /**
     * 
     * 
     * 
     */
    public function getTransferredSosDetails($transferred_sos_device_ids, $search_key = '')
    {
        $query = self::select('imei','version','brand','model_name');
        if($search_key != '')
        {
            $query = $query->where('imei','LIKE','%'.$search_key."%");
        }
        return $query->whereIn('id',$transferred_sos_device_ids)->paginate(10);
    }
    
}
