<?php

namespace App\Modules\Vehicle\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{

	public $timestamps = false;
	
    protected $fillable = [
        'name', 'code','status','state_id'
    ];

    public function ticketConcessions(){
 		return $this->belongsToMany('App\Modules\Concession\Models\TicketConcession', 'vehicle_type_ticket_concession',  'vehicle_type_id', 'ticket_concession_id')->withPivot('id');
 	} 

}
