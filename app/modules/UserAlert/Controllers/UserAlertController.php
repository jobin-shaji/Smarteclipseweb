<?php 


namespace App\Modules\UserAlert\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Alert\Models\Alert;
use App\Modules\Alert\Models\AlertType;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class UserAlertController extends Controller {

    
    public function edit(Request $request)
    {
        // $decrypted = Crypt::decrypt($request->id);   
        //  $alert_type = AlertType::select(
        //     'id', 
        //     'code',                      
        //     'description',                                                       
        //     'deleted_at'
        // )
        // ->withTrashed()       
        // ->where('id',$decrypted)
        // ->get();
        // if($alert_type == null){
        //     return view('UserAlert::404');
        // }
        return view('UserAlert::alert-manager');
    }
     
}