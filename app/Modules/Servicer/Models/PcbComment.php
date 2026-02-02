<?php

namespace App\Modules\Servicer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcbComment extends Model
{
   
    protected $table = 'pcb_comments';
    protected $fillable = ['pcb_id','comments','employee_id'];

   
   
    public function particulars()
    {
        return $this->hasMany(PcbParticular::class);
    }
    public function employee()
      {
        return $this->belongsTo('App\Modules\Employee\Models\Employee','employee_id','id');
      }
    
}
