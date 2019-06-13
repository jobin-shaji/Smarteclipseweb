<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class ZigZagDrivingReportController extends Controller
{
    public function zigZagDrivingReport()
    {
        return view('Reports::zig-zag-driving-report');  
    }  
   
}