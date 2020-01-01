<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DataTables;
class NfcCardReportController extends Controller {
    public function nfcCardReport ()
    {
        return view('Reports::nfc-card-report');
    }   
 }
