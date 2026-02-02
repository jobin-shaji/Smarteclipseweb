<?php

namespace App\Modules\Servicer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcbIn extends Model
{
   
    protected $table = 'cd_pcb_ins';
    protected $fillable = ['mongo_id','service', 'specs_width_mm', 'specs_height_mm', 'specs_layers', 'specs_quantity', 'specs_material', 'specs_finish', 'delivery_speed', 'bom_stats_total_lines', 'bom_stats_unique_parts', 'quote_currency', 'quote_total', 'status', 'user_id', 'sent_at', 'admin_quote_total', 'admin_quote_currency', 'admin_quote_notes',

'payment_proof_status', 'payment_proof_submitted_at', 'payment_proof_file_original_name', 'payment_proof_file_filename', 'payment_proof_file_mime_type', 'payment_proof_file_size', 'payment_proof_file_url',
'contact_name', 'contact_email', 'contact_company', 'contact_phone', 'contact_address', 
];
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

      public function attachments()
      {
          return $this->hasMany(PcbAttachment::class, 'quote_id', 'id');
      }
}
