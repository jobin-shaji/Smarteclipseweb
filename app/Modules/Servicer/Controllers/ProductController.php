<?php

namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Servicer\Models\Component;
use App\Modules\Servicer\Models\Product;
use App\Modules\Servicer\Models\Assets;
use App\Modules\Servicer\Models\ServiceStore;
use App\Modules\Servicer\Models\AssetsEmployeeAssign;
use App\Modules\Employee\Models\Employee;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class ProductController extends Controller
{
    public function index()
    {

        return view('Servicer::product-list');
    }
    public function getallproducts()
    {
        $service_in = Product::orderby('created_at', 'desc')->get();

        return DataTables::of($service_in)
        ->addIndexColumn()  
        ->addColumn('status', function ($service_in) {
            if($service_in->status== 1)
            {
                return "Active" ;
            }
          
            else
            {
                return "Disabled" ;
            }

         })
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');$a="";

            // <a onclick="sendservice('+data.id+',`sendtoservice`)" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
             if($service_in->invoice_name){
                $a.= "<a href=".$b_url."/uploads/".$service_in->invoice_name." class='btn btn-success btn-sm' download>Download Invoice</a>";
             
             }
               
              $a.= '
                   <a data-toggle="modal"  data-target="#myModal" onclick="edit(' .
                    $service_in->id.
                    ')" class="btn btn-danger"><i class="fa fa-paper-plane" aria-hidden="true"></i></a><a style="margin-right:3%;" class="btn btn-primary" onclick="deletes('.
                    $service_in->id. ')"  value="Delete"><i class="fa fa-trash"></i></a>';

                    return $a;
            
        })
        ->rawColumns(['link', 'action'])
        ->make();
        return response()->json(['products' => $products]);
    }


    //components


    public function getAllComponents()
    {
        if(\Auth::user()->hasRole('StoreKeeper')){
            $store_id=\Auth::user()->stores->store_id;
            $service_in = Component::orderby('created_at', 'desc')->where('store_id',$store_id)->get();
        }else{
            $store_id="";
            $service_in = Component::orderby('created_at', 'desc')->get();
        }
        
        return DataTables::of($service_in)
        ->addIndexColumn()  

        ->addColumn('store_id', function ($service_in) {
            if($service_in->store_id)
            {
                return $service_in->stores->name ;
            }
          
            else
            {
                return "---" ;
            }

         })
         ->addColumn('product_id', function ($service_in) {
            if($service_in->product_id)
            {
                return $service_in->products->name ;
            }
          
            else
            {
                return "---" ;
            }

         })
        ->addColumn('status', function ($service_in) {
            if($service_in->status== 1)
            {
                return "Active" ;
            }
          
            else
            {
                return "Disabled" ;
            }

         })
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');$a="";

            // <a onclick="sendservice('+data.id+',`sendtoservice`)" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
             
            if(\Auth::user()->hasRole('StoreKeeper')){
           //     $a.= "<a href=".$b_url."/uploads/".$service_in->invoice_name." class='btn btn-success btn-sm'>Assign Stock</a>";
             
                }
            if($service_in->invoice_name){
                $a.= "<a href=".$b_url."/uploads/".$service_in->invoice_name." class='btn btn-success btn-sm' download>Download Invoice</a>";
             
             }

            
               
              $a.= '
                  <a style="margin-right:3%;" class="btn btn-primary" onclick="deletes('.
                    $service_in->id. ')"  value="Delete"><i class="fa fa-trash"></i></a>';
                    $a.= "<a href=".$b_url."/edit-components/".$service_in->id." class='btn btn-success btn-sm'>Edit</a>";
        $a.= "<a href=".$b_url."/view-components/".$service_in->id." class='btn btn-success btn-sm'>View</a>";
           
                    return $a;
            
        })
        ->rawColumns(['link', 'action'])
        ->make();
        return response()->json(['products' => $products]);
    }
   
    public function create()
    {
        return view('Servicer::product-add');
    }
    public function store(Request $request)
    {
        if ($request->status == null) {
            $status = 0;
        } else {
            $status = 1;
        }
        
       
        if ($request->edit == "false") {
            $products = new Product();
            $products->name = $request->name;
            $products->description = $request->description;
          
            $products->status = $status;
            
            $products->save();
        } else {
            $products = Product::findorfail($request->edit);
            $products->name = $request->name;
            $products->description = $request->description;
         
            $products->status = $status;
            $products->save();
        }
        return redirect('service-products');
    }
    // create/store components

    public function storeComponents(Request $request)
    {

       
       
            $status = 1;
         if ($request->tax_type == true) {

            //  $tax = $request->price / (1 + $request->gst);
            $tax_type = 'inclusive';
            $tax =  $request->price - ($request->price * (100 / (100 + $request->gst)));
            $price = $request->price - $tax;
        } else if ($request->tax_type == '') {
            $tax_type = 'exclusive';
            $price = $request->price;
            $tax = ($price / 100) * $request->gst;
        }
       
        if ($request->edit == "false") {
 
            $products = new Component();
            $products->name = $request->name;
            $products->description = $request->description;
            $products->box_no = $request->box_no;
            $products->assets_id = $request->assets_id;
            $products->price = $price;
            $products->gst_percent = $request->gst;
            $products->stocks = $request->stocks;
            $products->units = $request->units;
            $products->min_quantity = $request->min_quantity;
            
            $products->gst = $tax;
            $products->tax_type = $tax_type;
            $products->total = $price + $tax;
             $products->customer_order = $request->customer_order;
             $products->product_id = $request->product_id;
             $products->store_id = $request->store_id;
           
            $products->status = $status;
            if ($request->hasFile('product_invoice')) {
           
                $file = $request->file('product_invoice');
                $filename = time() . '_' . $file->getClientOriginalName();
    
        // Move file to public/uploads
                 $file->move(public_path('uploads'), $filename);
    
                //$filePath = $request->file('products_csv')->store('uploads', 'public');
                $products->invoice_name = $filename;
            }

            if ($request->hasFile('image_url')) {
           
                $file = $request->file('image_url');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = \URL::to('/')."/uploads/";
        // Move file to public/uploads
                 $file->move(public_path('uploads'), $filename);
                 $fullFilePath = $destinationPath . $filename;
                //$filePath = $request->file('products_csv')->store('uploads', 'public');
                $products->image_url = $fullFilePath;
            }
            $products->save();
        } else {
            $products = Component::findorfail($request->edit);
            $products->name = $request->name;
            $products->description = $request->description;
            $products->box_no = $request->box_no;
            $products->assets_id = $request->assets_id;
            $products->price = $price;
            $products->gst_percent = $request->gst;
            $products->gst = $tax;
            $products->tax_type = $tax_type;
            $products->total = $price + $tax;
            $products->stocks = $request->stocks;
            $products->min_quantity = $request->min_quantity;
            $products->units = $request->units;
            $products->status = $status;
            $products->customer_order = $request->customer_order;
            $products->product_id = $request->product_id;
            $products->store_id = $request->store_id;
          
            if ($request->hasFile('product_invoice')) {
           
                $file = $request->file('product_invoice');
                $filename = time() . '_' . $file->getClientOriginalName();
    
        // Move file to public/uploads
                 $file->move(public_path('uploads'), $filename);
    
                //$filePath = $request->file('products_csv')->store('uploads', 'public');
                $products->invoice_name = $filename;
            }

            if ($request->hasFile('image_url')) {
           
                $file = $request->file('image_url');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = \URL::to('/')."/uploads/";
        // Move file to public/uploads
                 $file->move(public_path('uploads'), $filename);
                 $fullFilePath = $destinationPath . '/' . $filename;
                //$filePath = $request->file('products_csv')->store('uploads', 'public');
                $products->image_url = $fullFilePath;
            }
            $products->save();
        }
        return redirect('service-components');
    }
    public function delete($id)
    {
        $product = Component::findorfail($id);
        $delete = $product->delete();
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Product Deleted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Somthing Went Wrong']);
        }
    }
    public function getproduct($id)
    {
        $product = Component::findorfail($id);
        return $product;
    }

    public function getEditAssets($id)
    {
        $product = Assets::findorfail($id);
        return $product;
    }


    public function getEditComponents($id)
    {
      
        $components = Component::findorfail($id);

        $product=Product::select([
            'id',
            'name'
        ])
       
        ->get();
        $stores=ServiceStore::select([
            'id',
            'name'  ])->get();
        
       
        return view('Servicer::component-edit',['stores'=>$stores,'products'=>$product,'components'=>$components]);
      
    }

    public function select2products(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $employees = Component::orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $employees = Component::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee->id,
                "text" => $employee->name
            );
        }
        return response()->json($response);
    }

  /// Components start here

    public function componentList()
    {
        return view('Servicer::component-list');
       
    }
    /// Assets start here


    public function assetsList()
    {

        $employee=Employee::select('id','name')->get();
        return view('Servicer::assets-list',['employees'=>$employee]);
    }
    public function getallAssets()
    {
        $service_in = Assets::orderby('created_at', 'desc')->get();

        return DataTables::of($service_in)
        ->addIndexColumn()  
        ->addColumn('status', function ($service_in) {
            if($service_in->status== 1)
            {
                return "Active" ;
            }
          
            else
            {
                return "Disabled" ;
            }

         })
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');$a='';
            if($service_in->total>0){
 
             $a='<a data-toggle="modal"  data-target="#myModalA" onclick="assign(' .
                    $service_in->id.')" class="btn btn-danger">Assign</a>';
            }
            // <a onclick="sendservice('+data.id+',`sendtoservice`)" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>

            $a.= '
                   <a data-toggle="modal"  data-target="#myModals" onclick="edit(' .
                    $service_in->id.
                    ')" class="btn btn-danger"><i class="fa fa-paper-plane" aria-hidden="true"></i></a><a style="margin-right:3%;" class="btn btn-primary" onclick="deletes('.
                    $service_in->id. ')"  value="Delete"><i class="fa fa-trash"></i></a>';

        return $a;
            
        })
        ->rawColumns(['link', 'action'])
        ->make();
        return response()->json(['products' => $products]);
    }
    public function createComponents()
    {

        $product=Product::select([
            'id',
            'name'
        ])
       
        ->get();
        $stores=ServiceStore::select([
            'id',
            'name'  ])->get();
        
       
        return view('Servicer::component-add',['stores'=>$stores,'products'=>$product]);
    }
    public function storeAssets(Request $request)
    {

        if ($request->status == null) {
            $status = 0;
        } else {
            $status = 1;
        }
        

        if ($request->edit == "false") {
            $products = new Assets();
            $products->asset_code = $request->asset_code;
            $products->name = $request->name;
            $products->description = $request->description;
           
            $products->total = $request->total;
            $products->status = $status;
            $products->save();
        } else {
            $products = Assets::findorfail($request->edit);
            $products->asset_code = $request->asset_code;
            $products->name = $request->name;
            $products->description = $request->description;
           
            $products->total = $request->total;
            $products->status = $status;
            $products->save();
        }
        return redirect('service-assets');
    }
    public function deleteAssets($id)
    {
        $product = Assets::findorfail($id);
        $delete = $product->delete();
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Product Deleted Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Somthing Went Wrong']);
        }
    }


    public function assignAssets(Request $request)
    {
       
  
        $ass=AssetsEmployeeAssign::where('asset_id',$request->asset_id)->where('employee_id',$request->assign_id)->first();
     
       if(!$ass){

        $assign=New AssetsEmployeeAssign();
         $assign->asset_id=$request->asset_id;
        $assign->employee_id=$request->employee_id;
        $assign->save();
        $ass=Assets::where('id',$request->asset_id)->first();
        $ass->total=$ass->total-1;
        $ass->save();
        return redirect('service-assets');
       }
       
    }

    public function viewComponents($id)
    {
        $product = Component::findorfail($id);
        return view('Servicer::component-details',['component'=>$product]);
      
    }

}
