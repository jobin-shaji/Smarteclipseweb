<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Student\Models\Student;
use App\Modules\Vehicle\Models\Vehicle;
use Auth;
use DataTables;
class PickupDropoffReportController extends Controller {
    public function pickupReportBasedOnStudent()
    {
    	$client_id=\Auth::user()->client->id;
    	$students=Student::select('id','code','name')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::pickup-dropoff-report-based-on-student',['students'=>$students]);
    }  
    public function pickupReportBasedOnBus()
    {
    	$client_id=\Auth::user()->client->id;
    	$vehicles=Vehicle::select('id','name','register_number','client_id')
        ->where('client_id',$client_id)
        ->get();
        return view('Reports::pickup-dropoff-report-based-on-bus',['vehicles'=>$vehicles]);
    } 
     
 }
