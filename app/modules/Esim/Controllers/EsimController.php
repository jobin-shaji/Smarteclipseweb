<?php
namespace App\Modules\Esim\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Root\Models\Root;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Esim\Models\SimActivationDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon AS Carbon;
use DataTables;
use PDF;
use App\Jobs\MailJob;
use App\Http\Traits\MqttTrait;
use App\Mail\EsimPdf;

use Illuminate\Support\Facades\Mail;

class EsimController extends Controller {
     /**
     * 
     * @author PMS
     * 
     */
    public function getEsimDetails(Request $request)
    {
      
        $manufacturer_id                    =   \Auth::user()->root->id;
        $search_key                         =   ( isset($request->search) ) ? $request->search : null;  
        $from_date                          =   ( isset($request->fromDate) ) ? date("Y-m-d", strtotime($request->fromDate)): null; 
        $to_date                            =   ( isset($request->toDate) ) ? date("Y-m-d", strtotime($request->toDate)): null; 
        $download_type                      =   ( isset($request->type) ) ? $request->type : null;        
        $esim_list                          =   (new SimActivationDetails())->getSimActivationList($search_key,$from_date,$to_date,$download_type);
        //    plan  count
        $role_count                         =   (new SimActivationDetails())->roleBasedCount($search_key,$from_date,$to_date,$download_type);
        $manufacturer_details               =   (new Root())->getManufacturerDetails($manufacturer_id);
        $role_count_data                    =   [];    
        $role_count_total                   =   0;   
       if( $role_count )
       {
                 
            foreach($role_count as $item)
            {
                $role_count_total = $role_count_total + $item->count;
                $role_count_data [$item->role]  =[
                    "count"  => $item->count
                ];
            }
       } 
        //    plan  count
        if($request->ajax())
        {            
            return ($esim_list != null) ? Response([ 'lists' => $esim_list->appends(['search'=>$search_key,'from_date'=> $from_date,'to_date'=>$to_date]) ,'link'=> (string)$esim_list->render() ]) : Response([ 'lists' => $esim_list->appends(['search'=>$search_key,'from_date'=> $from_date,'to_date'=>$to_date]) ,'link'=> (string)$esim_list->render() ]);
        }
        if($download_type == 'pdf')
        {
            $pdf                    =   PDF::loadView('Esim::esim-activation-details-download',['esim_lists' => $esim_list,'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => $request->fromDate, 'to_date' => $request->toDate,'role_count'=>$role_count_data, 'role_count_total' =>  $role_count_total,'generated_by' => ucfirst(strtolower($manufacturer_details->name)).' '.'( Manufacturer )']);
            return $pdf->download('device plan expiry report.pdf');
        }
        else{
            return view('Esim::esim-activation-details-list')->with([ 'lists' => $esim_list,'search_key'=>$search_key,'from_date'=>$request->fromDate,'to_date'=>$request->toDate]);   
        }
    }
    public function getDetails(Request $request)
    {
        $esim_details    = (new SimActivationDetails())->getSimActivationDetails(Crypt::decrypt($request->id));
        if($esim_details == null)
        {
            return view('Esim::404');
        }
        return view('Esim::esim-activation-details',['esim' => $esim_details]);
    }
    public function esimDetailIdEncription(Request $request)
    {
       return $encrypt_sim_activation_id=Crypt::encrypt($request['sim_activation_id']);
    }
    public function esimSortByDate(Request $request)
    {
        $esim_details    = (new SimActivationDetails())->getSimActivationDetails(Crypt::decrypt($request->id));
        //    dd($request->from_date); 
    }
   
}
