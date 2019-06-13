<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class AccidentImpactAlertReportController extends Controller
{
    public function accidentImpactAlertReport()
    {
        return view('Reports::accident-impact-alert-report');  
    }  
   
}