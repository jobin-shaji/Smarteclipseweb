<?php
namespace App\Modules\Alert\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertType extends Model
{
    use SoftDeletes;    
	protected $fillable=[
		'code','description','status','path','deleted_at'
	];
}
