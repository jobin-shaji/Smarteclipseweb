<?php

namespace App\Modules\Configuration\Models;
use Illuminate\Database\Eloquent\Model;
class Configuration extends Model
{
   protected $fillable=[
		'name','value','code','date','version'
	];

  public function create($data){
   return Self::create($data);
  }
}
