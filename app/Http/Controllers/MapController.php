<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Queue;
use App\Exceptions\CustomException;
use \Carbon\Carbon;
use \Exception;
use \stdClass;
use App\Modules\User\Models\User;
use App\Mail\UserCreated;
use Doctrine\DBAL\Schema\View;
use Illuminate\Support\Facades\Mail;

class MapController extends Controller
{
    
    public function __construct()
    {
   
    }

    public function LoadMap()
    {
        return View("LoadMap");

    }

}
