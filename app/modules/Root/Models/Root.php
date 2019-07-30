<?php
namespace App\Modules\Root\Models;
use Illuminate\Database\Eloquent\Model;

class Root extends Model
{
    public function dealers(){
      return $this->hasMany('App\Modules\Dealer\Models\Dealer');
    }
}
