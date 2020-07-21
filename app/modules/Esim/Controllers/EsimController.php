<?php
namespace App\Modules\Esim\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Esim\Models\SimActivationDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use DataTables;
class EsimController extends Controller {
     /**
     * 
     * @author PMS
     * 
     */
    public function getEsimDetails(Request $request)
    {
      
        
        $search_key                         =   ( isset($request->search) ) ? $request->search : null;  
        $from_date                          =   ( isset($request->fromDate) ) ? date("Y-m-d", strtotime($request->fromDate)): null; 
        $to_date                            =   ( isset($request->toDate) ) ? date("Y-m-d", strtotime($request->toDate)): null; 
        $esim_list = (new SimActivationDetails())->getSimActivationList($search_key,$from_date,$to_date);
        
        if($request->ajax())
        {            
            return ($esim_list != null) ? Response([ 'lists' => $esim_list->appends(['search'=>$search_key]) ,'link'=> (string)$esim_list->render() ]) : Response([ 'links' => null]);
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
