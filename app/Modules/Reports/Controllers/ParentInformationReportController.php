<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
class ParentInformationReportController extends Controller {
    public function parentInformationReport ()
    {
        return view('Reports::parent-information-report');
    }   
 }
