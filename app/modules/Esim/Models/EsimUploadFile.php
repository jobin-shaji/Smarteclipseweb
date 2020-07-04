<?php

namespace App\Modules\Esim\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon AS Carbon;

class EsimUploadFile extends Model
{
    protected $fillable=[
    'name'];
    public function esimFilenamecount($filename)
    {
        return self::select('id','name')->where('name', $filename)->count();
    }
    public function esimFilenameSave($filename)
    {
      return  self::create([
          'name'=>$filename
        ]);
    }
}
