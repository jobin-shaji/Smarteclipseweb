<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\GpsData;
use DataTables;
class DailyKMReportController extends Controller
{
    public function dailyKMReport()
    {
        return view('Reports::daily-km-report');  
    }  
   
}