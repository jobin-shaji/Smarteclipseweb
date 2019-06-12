<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class SuddenAccelerationReportController extends Controller
{
    public function suddenAccelerationReport()
    {
        return view('Reports::sudden-acceleration-report');  
    }  
   
}