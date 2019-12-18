<?php

namespace App\Modules\Version\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationVersion extends Model
{
    use SoftDeletes;
      protected $fillable=['name','android_version','ios_version','description','android_version_code','android_version_priority','ios_version_code','ios_version_priority'];
}
