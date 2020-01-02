<?php
namespace App\Modules\Operations\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class VehicleMake extends Model
{
    use SoftDeletes;    
    protected $fillable=[
		'name'
	];
}
