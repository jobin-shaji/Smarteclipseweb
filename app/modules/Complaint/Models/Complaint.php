<?php

namespace App\Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
  protected $fillable=[
		'ticket_id','gps_id','complaint_type_id','description','client_id','status','servicer_id','assigned_by'
	];

	public function gps()
	{
  	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
	}

  public function ticket()
  {
    return $this->hasOne('App\Modules\Ticket\Models\Ticket','id','ticket_id');
  }

	public function complaintType()
	{
  	return $this->hasOne('App\Modules\Complaint\Models\ComplaintType','id','complaint_type_id')->withTrashed();
	}

	// client
  public function client(){
      return $this->hasOne('App\Modules\Client\Models\Client','id','client_id');
  }

  // user
  public function user(){
      return $this->hasOne('App\Modules\User\Models\User','id','response_by');
  }

  // client
  public function servicer(){
      return $this->hasOne('App\Modules\Servicer\Models\Servicer','id','servicer_id');
  }
}
