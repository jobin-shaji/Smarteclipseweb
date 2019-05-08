<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    // document fillable data
	protected $fillable = [
        'vehicle_id','document_type_id','expiry_date', 'path'
    ];

    public function vehicle(){
  		return $this->hasOne('App\Modules\Vehicle\Models\Vehicle','id','vehicle_id');
  	}

  	public function documentType(){
  		return $this->hasOne('App\Modules\Vehicle\Models\DocumentType','id','document_type_id');
  	}

}
