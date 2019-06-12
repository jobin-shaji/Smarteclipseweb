<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class TotalKMReportController extends Controller
{
    public function totalKMReport()
    {
        return view('Reports::total-km-report');  
    }  
   
}