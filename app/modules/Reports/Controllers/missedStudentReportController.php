<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
class missedStudentReportController extends Controller {
    public function missedStudentReport ()
    {
        return view('Reports::missed-student-report');
    }   
 }
