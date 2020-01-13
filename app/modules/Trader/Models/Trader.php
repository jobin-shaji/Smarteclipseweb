<?php

namespace App\Modules\Trader\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;

class Trader extends Model
{
    use SoftDeletes;
 
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

    protected $fillable=[ 'user_id','sub_dealer_id','name','address'];

    //with user table
    public function user()
    {
      return $this->belongsTo('App\Modules\User\Models\User')->withTrashed();
    }
  
    // with sub dealer table
    public function subDealer()
    {
      return $this->hasOne('App\Modules\SubDealer\Models\SubDealer','id','sub_dealer_id')->withTrashed();
    }

}
