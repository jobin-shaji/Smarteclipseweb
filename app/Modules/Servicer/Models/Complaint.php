<?php

namespace App\Modules\Servicer\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    
   protected $table='cd_complaints';
    protected $fillable=['name','status'];
}
