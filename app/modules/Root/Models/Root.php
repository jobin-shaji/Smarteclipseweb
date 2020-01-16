<?php
namespace App\Modules\Root\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Root extends Model
{
  use SoftDeletes;
  
    public function dealers(){
      return $this->hasMany('App\Modules\Dealer\Models\Dealer');
    }
}
