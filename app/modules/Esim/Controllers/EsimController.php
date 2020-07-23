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
use App\Mail\UserCreated;
use App\Mail\UserCreatedWithoutEmail;
use App\Mail\UserUpdated;
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
            return ($esim_list != null) ? Response([ 'lists' => $esim_list->appends(['search'=>$search_key]) ,'link'=> (string)$esim_list->render() ]) : Response([ 'links' => null]);
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
    public function getEsimMail()
    {
        $mytime = Carbon::now();
        $firstDateOfNextMonth =strtotime('first day of next month') ;
        $firstDay = date('Y-m-d', $firstDateOfNextMonth);
        $lastDateOfNextMonth =strtotime('last day of next month') ;
        $lastDay = date('Y-m-d', $lastDateOfNextMonth);
        $search_key=null;
        $download_type='pdf';
        $manufacturer_id                    =   \Auth::user()->root->id;      
        $esim_list                          =   (new SimActivationDetails())->getSimActivationList($search_key,$firstDay,$lastDay,$download_type);
        //    plan  count
        $role_count                         =   (new SimActivationDetails())->roleBasedCount($search_key,$firstDay,$lastDay,$download_type);
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
       $data=['esim_lists' => $esim_list,'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => $firstDay, 'to_date' => $lastDay,'role_count'=>$role_count_data, 'role_count_total' =>  $role_count_total,'generated_by' => ucfirst(strtolower($manufacturer_details->name)).' '.'( Manufacturer )'];
       $pdf                    =   PDF::loadView('Esim::esim-activation-details-download',$data);
       $path = public_path('pdf/');
       $fileName =  'device plan expiry report'. '.' . 'pdf' ;
       $pdf->save($path . '/' . $fileName);




       $data["email"]='developer.php04@vstmobility.com';
        $data["client_name"]='jisna';
        $data["subject"]="Report";

        // $pdf = PDF::loadView('mails.mail', $data);
        // $email = [
        //     'to'        =>  $user->email, 
        //     'toName'    =>  $root_details->name, 
        //     'template'  =>  'mail', 
        //     'subject'   =>  'Change password email at '.date('Y-m-d H:i:s'), 
        //     'data'      =>  [ 'name' =>$root_details->name,'content' =>'Your new password is '.$request->password ]
        // ];
        // MailJob::dispatch($email);




        try{
            
            Mail::send('Esim::esim-activation-details-download', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "invoice.pdf");
            });
            }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));














       return $pdf->download($fileName);
       
    //    return $pdf->download('device plan expiry report.pdf');
    //    dd($role_count_data);
        
    }
}
