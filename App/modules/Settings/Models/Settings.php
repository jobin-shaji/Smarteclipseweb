<?php

namespace App\Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable=[ 'name','email'];
    public function getSettings()
	{
		return self::select(
			'id',
			'name',
			'email'			
		)
		->get();
	}
}
