<?php

namespace App\Modules\Version\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceEngineerApplication extends Model
{
    use SoftDeletes;
      protected $fillable=['name','version','description','priority','file'];
}
