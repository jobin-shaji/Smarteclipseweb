<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class OverSpeedReportController extends Controller
{
    public function overSpeedReport()
    {
        return view('Reports::over-speed-report');  
    }  
   
}