<?php
namespace App\Modules\Configuration\Models;
use Illuminate\Database\Eloquent\Model;
class ConfigurationVersion extends Model
{
  	protected $fillable=[
		'plan','version'
	];
}
