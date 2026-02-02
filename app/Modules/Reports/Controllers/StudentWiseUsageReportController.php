<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
class StudentWiseUsageReportController extends Controller {
    public function studentWiseUsageReport ()
    {
        return view('Reports::student-wise-usage-report');
    }   
 }
