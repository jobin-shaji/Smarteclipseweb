<?php

namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Modules\Servicer\Models\Servicer;
use App\Modules\User\Models\User;
use DataTables;

class ServicerController extends Controller {
    

    public function create()
    {
        return view('Servicer::create');
    }

    public function save(Request $request)
    {
        $rules = $this->servicerCreateRules();
        $this->validate($request, $rules);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'status' => 1,
        ]);

        $user->assignRole('servicer');

        if($request->user()->hasRole('root')){
            $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 1,
                'status' => 0,
                'user_id' => $user->id
            ]);
        }else{
             $servicer = Servicer::create([
                'name' => $request->name,
                'address' => $request->address,
                'type' => 2,
                'status' => 0,
                'sub_dealer_id' => $request->user()->id,
                'user_id' => $user->id
            ]);
        }

        $request->session()->flash('message', 'New servicer successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('servicer.details',encrypt($servicer->id)));
    }

    public function list()
    {
        return view('Servicer::list'); 
    }

    public function edit(Request $request){
        $servicer = Servicer::find(decrypt($request->id));
        if($servicer == null){
           return view('User::404');
        }
        return view('Servicer::edit',compact('servicer'));
    }

    public function update(Request $request)
    {
        $servicer = Servicer::find($request->id);
        if($servicer == null){
           return view('User::404');
        }

        $rules = $this->servicerUpdateRules($servicer->user);
        $this->validate($request,$rules);

  
        $servicer->name = $request->name;
        $servicer->address = $request->address;
        $servicer->save();

        $user = User::find($servicer->user->id);
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();

        $request->session()->flash('message', 'Servicer details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect()->route('servicer.details',['id' => encrypt($servicer->id)]);

    }

    public function delete(Request $request)
    {
        $servicer=Servicer::find($request->id);
        if($servicer == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Servicer does not exist'
            ]);
        }
        $servicer->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Servicer deleted successfully'
        ]);
    }

    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $servicer=Servicer::find($decrypted_id);
        if($servicer==null){
            return view('Route::404');
        } 
        return view('Servicer::details',compact('servicer'));
    }

    public function activate(Request $request)
    {
        $servicer = Servicer::withTrashed()->find($request->id);
        if($servicer==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Servicer does not exist'
             ]);
        }
        $servicer->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Servicer restored successfully'
        ]);
    }

    public function p_List(Request $request)
    {
        $servicer = Servicer::select(
                    'id',
                    'name',
                    'address',
                    'user_id',
                    'deleted_at'
                    )
            ->with('user')
            ->withTrashed();
        if($request->user()->hasRole('root')){
            $servicer = $servicer->where('type',1);
        }else{
            $servicer = $servicer->where('type',2)->where('sub_dealer_id',$request->user()->id);
        }
        $servicer->get();
        return DataTables::of($servicer)
            ->addIndexColumn()
            ->addColumn('action', function ($servicer) {
                if($servicer->deleted_at == null){
                    return "
                    <a href=/servicer/".Crypt::encrypt($servicer->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>

                    <button onclick=delServicer(".$servicer->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate'><i class='fas fa-trash'></i> Deactivate</button>
                    <a href=/servicer/".Crypt::encrypt($servicer->id)."/edit class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> Edit</a>"; 
                }else{
                     return "
                    <a href=/servicer/".Crypt::encrypt($servicer->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='View'><i class='fas fa-eye'></i> View</a>
                    <button onclick=activateServicer(".$servicer->id.") class='btn btn-xs btn-success'data-toggle='tooltip' title='Activate'><i class='fas fa-check'></i> Activate</button>"; 

                }
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }
    
    public function servicerCreateRules()
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required',
            'mobile' => 'required'
        ];
        return  $rules;
    }

    public function servicerUpdateRules($user)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'address' => 'required',
            'mobile' => 'required'
        ];
        return  $rules;
    }

}
