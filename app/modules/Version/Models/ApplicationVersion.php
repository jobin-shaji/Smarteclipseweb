<?php

namespace App\Modules\Version\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationVersion extends Model
{
    use SoftDeletes;
      protected $fillable=['name','android_version','ios_version','description'];
}
