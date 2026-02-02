<?php

namespace App\Modules\Servicer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcbTransfer extends Model
{
   
    protected $table = 'pcb_transfers';
    protected $fillable = ['pcb_id','department_id'];

   
   
    public function particulars()
    {
        return $this->hasMany(PcbParticular::class);
    }
    public function renewalcert()
    {
        return $this->hasOne(RenewalCertificate::class, 'service_in_id', 'id');
    }
     public function ServiceCenter()
      {
        return $this->belongsTo('App\Modules\Servicer\Models\ServiceCenter','service_center_id','id');
      }
}
