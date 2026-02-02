<?php

namespace App\Modules\Sos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class SosTransfer extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

	// fillable fields
    protected $fillable=['from_user_id','to_user_id','order_number','scanned_employee_code','invoice_number','dispatched_on','accepted_on'];

	//join user table with sos table
    public function sos()
    {
    	return $this->hasOne('App\Modules\Sos\Models\Sos','id','sos_id');
    }

	//join user table with gps table
    public function fromUser()
    {
    	return $this->hasOne('App\Modules\User\Models\User','id','from_user_id');
    }

    //join user table with gps table
    public function toUser()
    {
    	return $this->hasOne('App\Modules\User\Models\User','id','to_user_id');
    }

    public function sosTransferItems()
    {
        return $this->hasMany('App\Modules\Sos\Models\SosTransferItems','sos_transfer_id','id');
    }
}
