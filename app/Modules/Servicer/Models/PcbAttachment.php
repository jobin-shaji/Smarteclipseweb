<?php

namespace App\Modules\Servicer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PcbAttachment extends Model
{
   
    protected $table = 'pcb_attachments';
    protected $fillable = ['quote_id','kind', 'original_name', 'filename', 'mime_type', 'size', 'url', 'attachment_id', 
];


public function pcb()
    {
        return $this->belongsTo(PcbIn::class);
    }
}
