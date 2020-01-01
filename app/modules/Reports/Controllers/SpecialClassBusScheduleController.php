<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
class SpecialClassBusScheduleController extends Controller {
    public function specialClassBusSchedule ()
    {
        return view('Reports::special-class-bus-schedule');
    }   
 }
