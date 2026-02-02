<?php

namespace App\Modules\Servicer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceIn extends Model
{
   
    protected $table = 'cd_service_ins';
    protected $fillable = ['service_center_id','payment_date', 'delivery_date', 'is_dealer', 'discount', 'installation_date', 'warranty', 'vehicle_no', 'dealername', 'dealermobile', 'date', 'serial_no', 'entry_no', 'imei', 'customer_name', 'address', 'customermobile', 'complaint_type', 'comments'];

    protected $appends = ['fdate', 'finstallation'];
    protected function getFdateAttribute()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }
    protected function getFinstallationAttribute()
    {
        return Carbon::parse($this->installation_date)->format('d-m-Y');
    }

    public function type()
    {
        return $this->belongsTo(Complaint::class, 'complaint_type', 'id');
    }
    public function particulars()
    {
        return $this->hasMany(ServiceParticular::class);
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
