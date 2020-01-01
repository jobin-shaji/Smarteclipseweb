<?php
namespace App\Modules\Client\Models;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

  public $timestamps = false;
  
	protected $fillable=[
		'reference_id','client_id','amount','subscription'
	];	
  
  
}

