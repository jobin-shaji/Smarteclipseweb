<?php 
namespace App\Modules\Configuration\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Configuration\Models\Configuration;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Auth;
use DataTables;
use DB;
use Config;
class ConfigurationController extends Controller {
    public function create()
    {
        $items = Configuration::all(); 
       return view('Configuration::configuration-create',['config'=> $items]);
    }
    public function save(Request $request)
    {
        if($request->user()->hasRole('root')){ 
            $dealer = Configuration::create([
                'name' => $request->name,
                'value'=>$request->config,
                'code' => $request->code,            
              
            ]);
        }
        $request->session()->flash('message', 'New Configuration created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('configuration.create')); 
    }
    public function getConfiguration(Request $request)
    {  
        $items = Configuration::find(1);  
        
        return response()->json([
                'config' => $items        
        ]);
    }
}