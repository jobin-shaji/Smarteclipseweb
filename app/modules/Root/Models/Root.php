<?php
namespace App\Modules\Root\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Root extends Model
{
  use SoftDeletes;
  
  public function dealers()
  {
    return $this->hasMany('App\Modules\Dealer\Models\Dealer');
  }

  public function getManufacturerDetails($root_id)
  {
    return self::select('id','name')->where('id',$root_id)->first();
  }

  public function checkUserIdIsInManufacturerTable($user_id)
  {
    return self::select('name')->where('user_id',$user_id)->first();
  }

}
