<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;

class ClientTransaction extends Model
{

  public $timestamps = false;
  
	protected $fillable=[
		'reference_id','transaction_id','amount','status','payment_date','gateway'
	];	
  
  
}

