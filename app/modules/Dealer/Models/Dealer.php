<?php
namespace App\Modules\Dealer\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dealer extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'user_id','name','root_id','address','phone_number','email','status','created_by','deleted_by','deleted_at'
	];
	// users of a depot
	public function user()
    {
    	return $this->belongsTo('App\Modules\User\Models\User','user_id','id');
    }

    
}
