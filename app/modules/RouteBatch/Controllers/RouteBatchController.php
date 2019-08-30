<?php
namespace App\Modules\RouteBatch\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\RouteBatch\Models\RouteBatch;
use App\Modules\Route\Models\Route;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class RouteBatchController extends Controller {
   
    //route batch creation page
    public function create()
    {
        $client_id = \Auth::user()->client->id;
        $routes=Route::select([
                    'id',
                    'name'  
                ])
                ->where('client_id',$client_id)
                ->get();  
       return view('RouteBatch::route-batch-create',['routes' => $routes]);
    }
    //upload route batch details to database table
    public function save(Request $request)
    {    
        $client_id = \Auth::user()->client->id;
        $rules = $this->routeBatchCreateRules();
        $this->validate($request, $rules);           
        $route_batch = RouteBatch::create([            
            'name' => $request->name,            
            'route_id' => $request->route_id,
            'client_id' => $client_id,        
        ]);
        $eid= encrypt($route_batch->id);
        $request->session()->flash('message', 'New school created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('route-batch'));        
    }

    //route batch list
    public function routeBatchList()
    {
        return view('RouteBatch::route-batch-list');
    }

    public function getRouteBatchlist(Request $request)
    {
        $client_id = \Auth::user()->client->id;
        $route_batch = RouteBatch::select(
            'id', 
            'name',                   
            'route_id',
            'client_id',
            'deleted_at')
            ->with('route:id,name')
            ->where('client_id',$client_id)
            ->withTrashed()
            ->get();
            return DataTables::of($route_batch)
            ->addIndexColumn()
            ->addColumn('action', function ($route_batch) {
                 $b_url = \URL::to('/');
            if($route_batch->deleted_at == null){ 
                return "
                <button onclick=delRouteBatch(".$route_batch->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/route-batch/".Crypt::encrypt($route_batch->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                ";
            }else{                   
                return "
                <button onclick=activateRouteBatch(".$route_batch->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //edit route batch details
    public function edit(Request $request)
    {
        $client_id = \Auth::user()->client->id;
        $decrypted = Crypt::decrypt($request->id); 
        $route_batch = RouteBatch::find($decrypted);   
        $routes=Route::select([
                    'id',
                    'name'  
                ])
                ->where('client_id',$client_id)
                ->get();      
        if($route_batch == null)
        {
           return view('RouteBatch::404');
        }
        return view('RouteBatch::route-batch-edit',['route_batch' => $route_batch,'routes' => $routes]);
    }

    //update route batch details
    public function update(Request $request)
    {
        $route_batch = RouteBatch::where('id', $request->id)->first();
        if($route_batch == null){
           return view('RouteBatch::404');
        } 
        $rules = $this->routeBatchUpdateRules($route_batch);
        $this->validate($request, $rules);       
        $route_batch->name = $request->name;
        $route_batch->route_id = $request->route_id;
        $route_batch->save();      
        $did = encrypt($route_batch->id);
        $request->session()->flash('message', 'Route batch details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('route-batch.edit',$did));  
    }
  
    //deactivated route batch details from table
    public function deleteRouteBatch(Request $request)
    {
        $route_batch = RouteBatch::find($request->uid);
        if($route_batch == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Route batch does not exist'
            ]);
        }
        $route_batch->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Route batch deactivated successfully'
        ]);
    }


    // restore route batch
    public function activateRouteBatch(Request $request)
    {
        $route_batch = RouteBatch::withTrashed()->find($request->id);
        if($route_batch==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Route batch does not exist'
             ]);
        }

        $route_batch->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Route batch restored successfully'
        ]);
    }

    public function routeBatchCreateRules()
    {
        $rules = [
            'name' => 'required|unique:route_batches',
            'route_id' => 'required',
            
        ];
        return  $rules;
    }
     //validation for school updation
    public function  routeBatchUpdateRules($route_batch)
    {
        $rules = [
            'name' => 'required|unique:route_batches,name,'.$route_batch->id,
            'route_id' => 'required'
        ];
        return  $rules;
    }
}
