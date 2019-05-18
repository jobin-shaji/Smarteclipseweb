<?php 


namespace App\Modules\UserAlert\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;
use App\Modules\Client\Models\Client;
use App\Modules\Alert\Models\AlertType;
use App\Modules\Alert\Models\UserAlerts;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class UserAlertController extends Controller {

    
    public function edit(Request $request)
    {        
        $user = \Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        $root = $user->root;
        $alert_type = AlertType::all();
        

         $user_alert=array();
        foreach($alert_type as $alert_type){
            // $user_alert = UserAlerts::where('client_id', $client->id)->first();
           
            $user_alert[]=UserAlerts::select('client_id', 'alert_id', 'status')
                        ->where('client_id',$client->id)
                        ->with('alertType:id,description,code')
                        ->first();
        }

                                                   
        //  $alert_type = AlertType::select('description', 'id', 'code')
        // ->where('id',$user_alert->id)
        // ->get(); 

        return view('UserAlert::alert-manager',['user_alert' => $user_alert]);
    }
     
}