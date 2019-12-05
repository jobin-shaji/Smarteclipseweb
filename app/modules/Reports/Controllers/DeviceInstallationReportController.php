<?php
namespace App\Modules\Reports\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\ClientAlertPoint;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Alert\Models\UserAlerts;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Gps\Models\GpsLog;
use Auth;
use DataTables;
class DeviceInstallationReportController extends Controller {

    public function installationReport ()
    {
        $subdealer_id=\Auth::user()->subdealer->id;
        $clients=Client::where('sub_dealer_id',$subdealer_id)->get();
        $servicers=Servicer::where('sub_dealer_id',$subdealer_id)->get();
        return view('Reports::installation-report',['clients' => $clients,'servicers' => $servicers]);
    }   
    public function installationReportList(Request $request)
    { 
        $client_id = $request->data['client_id'];
        $servicer_id = $request->data['servicer_id'];
        $from_date = date("Y-m-d", strtotime($request->data['from_date']));
        $to_date = date("Y-m-d", strtotime($request->data['to_date']));
        $subdealer_id=\Auth::user()->subdealer->id;
        $clients=Client::where('sub_dealer_id',$subdealer_id)->get();
        $all_clients=[];
        foreach ($clients as $client) {
            $all_clients[]=$client->id;
        }
        $servicers=Servicer::where('sub_dealer_id',$subdealer_id)->get();
        $all_servicers=[];
        foreach ($servicers as $servicer) {
            $all_servicers[]=$servicer->id;
        }
        $completed_jobs = ServicerJob::select(
            'id', 
            'servicer_id',
            'client_id',
            'job_id',
            'job_type',
            'description',
            'job_complete_date',                
            'location',
            'gps_id'
        )
        ->whereNotNull('job_complete_date')
        ->with('gps:id,imei,serial_no')
        ->with('clients:id,name')
        ->with('servicer:id,name')
        ->whereDate('job_complete_date', '>=', $from_date)
        ->whereDate('job_complete_date', '<=', $to_date);
        if($client_id==0 && $servicer_id==0)
        { 
           $completed_jobs =$completed_jobs->whereIn('client_id',$all_clients)->whereIn('servicer_id',$all_servicers);
        }
        else if($client_id == 0 && $servicer_id != 0){
            $completed_jobs =$completed_jobs->whereIn('client_id',$all_clients)->where('servicer_id',$servicer_id);
            
        }
        else if($client_id != 0 && $servicer_id == 0){
            $completed_jobs =$completed_jobs->whereIn('servicer_id',$all_servicers)->where('client_id',$client_id);
        }
        else
        {
            $completed_jobs =$completed_jobs->where('servicer_id',$servicer_id)->where('client_id',$client_id);
        } 
        $completed_jobs =$completed_jobs->get();  
        return DataTables::of($completed_jobs)
        ->addIndexColumn()
        ->addColumn('job_type', function ($completed_jobs) {
            if($completed_jobs->job_type==1)
            {
                return "Installation" ; 
            }
            else
            {
                return "Service" ; 
            }
                       
         })
        ->make();
    }
   
}
