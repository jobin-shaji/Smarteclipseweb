<?php
namespace App\Modules\BusHelper\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\BusHelper\Models\BusHelper;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class HelperController extends Controller {
   
    //helper creation page
    public function create()
    {
       return view('BusHelper::helper-create');
    }
    //upload helper details to database table
    public function save(Request $request)
    {    
        $rules = $this->helperCreateRules();
        $this->validate($request, $rules);           
        $helper = BusHelper::create([            
            'name' => $request->name,  
            'helper_code' => $request->helper_code,           
            'mobile' => $request->mobile,   
            'address' => $request->address,      
        ]);
        $hid= encrypt($helper->id);
        $request->session()->flash('message', 'New helper created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('helper'));        
    }

    //helper list
    public function helperList()
    {
        return view('BusHelper::helper-list');
    }

    public function getHelperlist(Request $request)
    {
        $helper = BusHelper::select(
            'id', 
            'name',
            'helper_code',
            'address',               
            'mobile',
            'deleted_at')
            ->withTrashed()
            ->get();
            return DataTables::of($helper)
            ->addIndexColumn()
            ->addColumn('action', function ($helper) {
                 $b_url = \URL::to('/');
            if($helper->deleted_at == null){ 
                return "
                <button onclick=delHelper(".$helper->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/helper/".Crypt::encrypt($helper->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                 <a href=".$b_url."/helper/".Crypt::encrypt($helper->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'><i class='fas fa-eye'></i> View</a>
                ";
            }else{                   
                return "
                <button onclick=activateHelper(".$helper->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //edit helper details
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $helper = BusHelper::find($decrypted);       
        if($helper == null)
        {
           return view('BusHelper::404');
        }
        return view('BusHelper::helper-edit',['helper' => $helper]);
    }

    //update helper details
    public function update(Request $request)
    {
        $helper = BusHelper::where('id', $request->id)->first();
        if($helper == null){
           return view('BusHelper::404');
        } 
        $rules = $this->helperUpdateRules($helper);
        $this->validate($request, $rules); 
        $helper->helper_code = $request->helper_code;      
        $helper->name = $request->name;
        $helper->address = $request->address;
        $helper->mobile = $request->mobile;
        $helper->save();      
        $hid = encrypt($helper->id);
        $request->session()->flash('message', 'Helper details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('helper.edit',$hid));  
    }

    
    // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $helper=BusHelper::find($decrypted_id);
        if($helper==null){
            return view('BusHelper::404');
        } 
        return view('BusHelper::helper-details',['helper' => $helper]);
    }

  
    //deactivated helper details from table
    public function deleteHelper(Request $request)
    {
        $helper = BusHelper::find($request->uid);
        if($helper == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Helper does not exist'
            ]);
        }
        $helper->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Helper deactivated successfully'
        ]);
    }


    // restore helper
    public function activateHelper(Request $request)
    {
        $helper = BusHelper::withTrashed()->find($request->id);
        if($helper==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Helper does not exist'
             ]);
        }

        $helper->restore();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Helper activated successfully'
        ]);
    }

    public function helperCreateRules()
    {
        $rules = [
            'name' => 'required',
            'helper_code' => 'required|unique:bus_helpers',
            'mobile' => 'required|string|min:10|max:10|unique:bus_helpers',  
            'address' => 'required',
        ];
        return  $rules;
    }
     //validation for helper updation
    public function helperUpdateRules($helper)
    {
        $rules = [
            'name' => 'required',
            'helper_code' => 'required|unique:bus_helpers,helper_code,'.$helper->id,
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:bus_helpers,mobile,'.$helper->id
        ];
        return  $rules;
    }
}
