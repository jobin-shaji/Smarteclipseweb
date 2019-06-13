<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class HarshBrakingReportController extends Controller
{
    public function harshBrakingReport()
    {
        return view('Reports::harsh-braking-report');  
    }  
   
}