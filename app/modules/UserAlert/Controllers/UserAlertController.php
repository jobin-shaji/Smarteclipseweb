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
        $user_alert = UserAlerts::select('client_id', 'alert_id', 'status')
        ->where('client_id',$client->id)
        ->where('alert_id','!=',21)
        ->with('alertType:id,description,code')
        ->get();
        return view('UserAlert::alert-manager',['user_alert' => $user_alert]);
    }
    public function savealertManager(Request $request) 
    {       
        $user_id = \Auth::user()->id;
        $client = Client::where('user_id', $user_id)->first();
        $alert = AlertType::all(); 
        foreach ($alert as $alert) { 
            $user_item = UserAlerts::where('alert_id', $alert->id)->where('client_id', $client->id)->first();             
            if($user_item)
            { 
                $user_item->status =0;
                $user_item->save();
            }
        }
        $rules = $this->alertManagerRule();
        $this->validate($request, $rules);       
        $alert_array = $request->alert_id; 
        if($alert_array){
            foreach ($alert_array as $alert_id) {                           
                $user_alert = UserAlerts::where('alert_id', $alert_id)->where('client_id', $client->id)->first();                
                if($user_alert)
                {
                    $user_alert->status =1;
                    $user_alert->save();                         
                }                
            }
        }                      
        $request->session()->flash('message', 'Alert manager successfully updated!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('alert.manager'));
    }
       // gps transfer rule
    public function alertManagerRule(){
        $rules = [
          'alert_id' => 'required'];
        return $rules;
    }
}