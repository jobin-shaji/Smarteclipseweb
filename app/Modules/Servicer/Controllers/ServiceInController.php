<?php
 
namespace App\Modules\Servicer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Servicer\Models\AppSettings;
use App\Modules\Servicer\Models\Complaint;
use App\Modules\Gps\Models\Gps;
use App\Modules\Servicer\Models\Component;
use App\Modules\Servicer\Models\ServiceIn;
use App\Modules\Servicer\Models\ServiceParticular;
use App\Modules\TrafficRules\Models\Country;
use App\Modules\TrafficRules\Models\State;
use App\Modules\TrafficRules\Models\City;
use App\Modules\Servicer\Models\ServiceCenter;
use App\Modules\Servicer\Models\ServiceStore;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use DataTables;


class ServiceInController extends Controller
{
    public function ServiceDeviceReport ()
    {
      $statuses = ServiceIn::query()
            ->select('status')
            ->distinct()
            ->whereNotNull('status')
            ->orderBy('status')
            ->pluck('status');
    
        return view('Servicer::service-device-report', [
            'statuses' => $statuses
        ]);
    }
    public function ServiceDeviceStatusReport(Request $request)
    {
        $status = $request->query('status');
    
        if (!empty($status)) {
            // ?? Fetch records with selected status
            $services = ServiceIn::where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get([
                    'entry_no',
                    'imei',
                    'vehicle_no',
                    'customer_name',
                    'date',
                    'customermobile',
                    'dealer_name',
                    'comments',
                    'delivery_date',
                    'service_center_id',
                    'status',
                    'created_at'
                ]);
        } else {
            // ?? Fetch ALL records
            $services = ServiceIn::orderBy('created_at', 'desc')
                ->get([
                    'entry_no',
                    'imei',
                    'vehicle_no',
                    'customer_name',
                    'date',
                    'customermobile',
                    'dealer_name',
                    'comments',
                    'delivery_date',
                    'service_center_id',
                    'status',
                    'created_at'
                ]);
        }
    
        return response()->json($services);
    }
    public function cancelledstatus()
    {
        if (auth('web')->user()->hasRole('Super Admin')) {
            return view('cancelled.index');
        }else{
            return 'you are not authorized';
        }
    }
    public function AddServiceCenter(Request $request)
    {

        $countries=Country::select([
            'id',
            'name'
        ])
        ->where('id',101)
        ->get();
         $url=url()->current();
        
         $rayfleet_key="rayfleet";
         $eclipse_key="eclipse";
         if (strpos($url, $rayfleet_key) == true) {  
            $default_country_id="178";
          }else if (strpos($url, $eclipse_key) == true) {
            $default_country_id="101";
          }else
          {
         $default_country_id="101";
          }
        $logged_user_id = \Auth::user()->id;
        return view('Servicer::service-center-create',['countries'=>$countries,'default_country_id'=>$default_country_id,'logged_user_id'=>$logged_user_id]);

    }
    public function AddnewStore(Request $request)
    {

        $countries=Country::select([
            'id',
            'name'
        ])
        ->where('id',101)
        ->get();
         $url=url()->current();
        
         $rayfleet_key="rayfleet";
         $eclipse_key="eclipse";
         if (strpos($url, $rayfleet_key) == true) {  
            $default_country_id="178";
          }else if (strpos($url, $eclipse_key) == true) {
            $default_country_id="101";
          }else
          {
         $default_country_id="101";
          }
        $logged_user_id = \Auth::user()->id;
        return view('Servicer::store-new-create',['countries'=>$countries,'default_country_id'=>$default_country_id,'logged_user_id'=>$logged_user_id]);

    }

   
    public function isverified($id)
    {
        $service = ServiceIn::findorfail($id);

        $service->is_verified = true;
        $status = $service->save();
        if ($status) {
            return response()->json(['status' => true, 'message' => 'Payment Verified']);
        } else {
            return response()->json(['status' => false, 'message' => 'Somthing Went Wrong']);
        }
    }
    public function indexseviceCenter()
    {
        return view('Servicer::list_center');
    }


    public function indexStores()
    {
        return view('Servicer::list_stores');
    }


    public function indexservicein()
    {
        return view('Servicer::deviceindex');
        //return view('Servicer::productionindex');
    }


    public function getIndexStore()
    {

        $service_in = ServiceStore::orderby('created_at', 'desc')->get();
        return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('action', function ($service_in) {
             $b_url = \URL::to('/');
           return "
            <a href=".$b_url."/store-edit/".Crypt::encrypt($service_in->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                <button onclick=delStore(".$service_in->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
      
    }

    public function getIndexServiceCenter()
    {

        $service_in = ServiceCenter::orderby('created_at', 'desc')->get();
        return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('action', function ($service_in) {
             $b_url = \URL::to('/');
           return "
            <a href=".$b_url."/client/".Crypt::encrypt($service_in->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
             <a href=".$b_url."/client/".Crypt::encrypt($service_in->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
               <button onclick=delClient(".$service_in->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
      
    }
    public function getIndexServiceIn()
    {

        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', '!=', 'cancelled')->where('status', '!=', 'delivered')->get();
       
        return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('date', function ($service_in) { 
           return   date('Y-m-d', strtotime($service_in->date));;
        })
        ->addColumn('status', function ($service_in) { 

            if ($service_in->status=='servicein') {
               return "Service";

            } if ($service_in->status=='sendtoservice')
            {
                return "Service";
               
            }else if ($service_in->status=='sendtocustomercare')
            {
                return "Customer Care";
            
            }else  if ($service_in->status=='sendtodelivery')
            {
                return "Delivery";
               
            }
            else  if ($service_in->status== 'completed') {
                return "Completed";
            }else  if ($service_in->status== 'customerapproved') {
                return "Approved";
               
            }})
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');

            if ($service_in->status == 'servicein') {



                // <a onclick="sendservice('+data.id+',`sendtoservice`)" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>

               return '
                    <a class="btn btn-light-grey btn-xs text-black" href="'.$b_url.'/edit-service-in-view/' .$service_in->id
                    .
                    '" ><i class="fa fa-edit"></i></a><a data-toggle="modal"  data-target="#myModal" onclick="setvalue(' .
                    $service_in->id.
                    ')" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a><a style="margin-right:3%;" class="btn btn-light-grey btn-xs text-black" onclick="deletes('.
                    $service_in->id. ')"  value="Delete"><i class="fa fa-trash"></i></a>';
            } else {
            return "
                <a href=".$b_url."/view-device-details/".$service_in->id."  class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
               

            }
            return "
            <a href=".$b_url."/view-device-details/".$service_in->id."  class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
         

        })
        ->rawColumns(['link', 'action'])
        ->make();
    
       
    }
    public function Status($status, $id)
    {
        $service = ServiceIn::findorfail($id);
        $service->status = $status;
        $status = $service->save();
        if ($status) {
            return response()->json(['status' => true, 'message' => 'Status Changed']);
        } else {
            return response()->json(['status' => false, 'message' => 'Somthing Went Wrong']);
        }
    }


    public function AddDeviceInView()
    {
        $complaint_type = Complaint::get();
        $service_in = ServiceIn::get();

        if (count($service_in) != 0) {
            $EntryNumber = $this->entry($service_in->last()->id);
        } else {
            $EntryNumber = 'SRV-0001';
        }

        $imeis = Gps::get();



        return view('Servicer::adddevicein')->with(['complaint_type' => $complaint_type, 'entry_no' => $EntryNumber, 'imeis' => $imeis]);
    }

  public function AddDeviceIn(Request $request)
    {
        // dd(123456);


        if ($request->warranty == '') {
            $warranty = 0;
        } else {
            $warranty = 1;
        }
        if ($request->is_renewal == '') {
            $renewal = 0;
        } else {
            $renewal = 1;
        }
        if ($request->is_dealer == 'Dealer') {
            $is_dealer = 1;
        } else {
            $is_dealer = 0;
        }

        $re = AppSettings::findorfail(1);

        if ($request->is_dealer == 'Dealer' && $request->is_renewal == true) {

            $toto = $re->DealerRenewAmount;
        } else if ($request->is_dealer == 'Customer' && $request->is_renewal == true) {
            $toto = $re->CusomerRenewAmount;
        } else {
            $toto = 0;
        }





        $service = new ServiceIn();
        $service->date = Carbon::parse($request->date)->toDateTimeString();
        $service->installation_date = Carbon::parse($request->instalationdate)->toDateTimeString();
        $service->status = 'servicein';
        $service->warranty = $warranty;
        $service->is_renewal = $renewal;
        $service->is_dealer = $is_dealer;
        $service->vehicle_no = $request->vehicle_no;
        $service->total = $toto;
        $service->serial_no = $request->slno;
        $service->entry_no = $request->entry_no;
        $service->imei = $request->imei;
        $service->customer_name = $request->customername;
        $service->address = $request->address;
        $service->customermobile = $request->customermobile;
        $service->dealermobile = $request->dealermobile;
        $service->dealer_name = $request->dealername;
        $service->complaint_type = $request->complaint_type;
        $service->comments = $request->comments;
        $service->msisdn = $request->msisdn;
        $service->sim1 = $request->sim1;
        $service->sim2 = $request->sim2;
        $save = $service->save();
        $message = "Dear Customer,
        Your GPS device has been received for service.
        VST Mobility Solutions.";
        $template_id = "1107166788618155856";
        if ($save) {
            (new SendSmsController)->sendmessage($message, $request->customermobile, $template_id);
        }

        return redirect('index-service-in');
    }




    public function EditServiceInView($id)
    {
        $imeis = gps::get();
        $complaint_type = Complaint::get();
        $servicein = ServiceIn::findorfail($id);
        return view('Servicer::editdevicein')->with(['servicein' => $servicein, 'complaint_type' => $complaint_type, 'imeis' => $imeis]);
    }


    public function EditServiceIn($id, Request $request)
    {

        if ($request->warranty == '') {
            $warranty = 0;
        } else {
            $warranty = 1;
        }
        if ($request->warranty == '') {
            $renewal = 0;
        } else {
            $renewal = 1;
        }
        if ($request->is_dealer == 'Dealer') {
            $is_dealer = 1;
        } else {
            $is_dealer = 0;
        }
        $re = AppSettings::findorfail(1);

        if ($request->is_dealer == 'Dealer' && $request->is_renewal == true) {

            $toto = $re->DealerRenewAmount;
        } else if ($request->is_dealer == 'Customer' && $request->is_renewal == true) {
            $toto = $re->CusomerRenewAmount;
        } else {
            $toto = 0;
        }



        $service = ServiceIn::findorfail($id);
        $service->date = Carbon::parse($request->date)->toDateTimeString();
        $service->installation_date = Carbon::parse($request->instalationdate)->toDateTimeString();
        $service->warranty = $warranty;
        $service->is_renewal = $renewal;
        $service->is_dealer = $is_dealer;
        $service->total = $toto;
        $service->vehicle_no = $request->vehicle_no;
        $service->serial_no = $request->slno;
        $service->entry_no = $request->entry_no;
        $service->imei = $request->imei;
        $service->customer_name = $request->customername;
        $service->address = $request->address;
        $service->customermobile = $request->customermobile;
        $service->dealermobile = $request->dealermobile;
        $service->dealer_name = $request->dealername;
        $service->complaint_type = $request->complaint_type;
        $service->comments = $request->comments;
        $service->msisdn = $request->msisdn;
        $service->sim1 = $request->sim1;
        $service->sim2 = $request->sim2;
        $service->save();
        return redirect('index-service-in');
    }

    public function ViewServiceIn($id)
    {
        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }
        return view('Servicer::viewdevicein')->with(['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }
    public function ViewDeviceDetail($id)
    {
        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }
        return view('servicedetails.index')->with(['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }


    public function productionindex()
    {
        return view('Servicer::productionindex');
    }

    public function GetIndexProduction()
    {

        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'sendtoservice')->orWhere('status', 'customerapproved')->orWhere('status', 'completed')->get();
       
        return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('date', function ($service_in) { 
           return   date('Y-m-d', strtotime($service_in->date));;
        })
        ->addColumn('status', function ($service_in) { 

            if ($service_in->status=='servicein') {
               return "Service";

            } if ($service_in->status=='sendtoservice')
            {
                return "Service";
               
            }else if ($service_in->status=='sendtocustomercare')
            {
                return "Customer Care";
            
            }else  if ($service_in->status=='sendtodelivery')
            {
                return "Delivery";
               
            }
            else  if ($service_in->status== 'completed') {
                return "Completed";
            }else  if ($service_in->status== 'customerapproved') {
                return "Approved";
               
            }})
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');


            if ($service_in->status == 'customerapproved') {
               return '
                    <a class="btn btn-light-grey btn-xs text-black" href="'.$b_url.'/productionview/' .$service_in->id
                    .
                    '" ><i class="fa fa-edit"></i></a>';
            } 
            else if ($service_in->status == 'completed') {



               return '<a data-toggle="modal"  data-target="#myModal" onclick="setvalue(' .
                    $service_in->id.
                    ')" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                    ';
            } else {
            return '
               <a data-toggle="modal"  data-target="#myModal" onclick="setvalue(' .
                    $service_in->id.
                    ')" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                    <a style="margin-left:3%;" class="btn btn-primary" href="'.$b_url.'/add-products-root/' .
                    $service_in->id. '"  type="button">Add</a>';

            }
            return "
            <a href=".$b_url."/view-device-details/".$service_in->id."  class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
         

        })
        ->rawColumns(['link', 'action'])
        ->make();
       
       
       
        return response()->json(['service_in' => $service_in]);
    }

    public function AddProductsView($id)
    {

       
        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }
        return view('Servicer::addcomponentsview')->with(['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }

    public function AddProducts($id, Request $request)
    {
        $servicein = ServiceIn::findorfail($id);
        // $servicein->status='sendtocustomercare';
        $servicein->save();
        $del = ServiceParticular::where('service_in_id', $id);

        if (count($del->get()) != 0) {
            try {
                ServiceParticular::where('service_in_id', $id)->delete();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        $i = 0;
        $totaltotal = 0;
        $totaltax = 0;
        $totalgross = 0;
        if ($request->productids != '') {
            foreach ($request->productids as $ids) {

                $products = Component::findorfail($ids);
                $particular = new ServiceParticular();
                $particular->service_in_id = $id;
                $particular->product_id = $ids;
                $particular->qty = $request->quantity[$i];
                $particular->comments = $request->comments[$i];
                $particular->price = $products->price;
                $particular->gross = $products->price * $request->quantity[$i];
                $particular->tax = $products->gst * $request->quantity[$i];
                $particular->total = ($products->price * $request->quantity[$i]) + ($products->gst * $request->quantity[$i]);
                $particular->save();
                $totaltotal += ($products->price * $request->quantity[$i]) + ($products->gst * $request->quantity[$i]);

                $totaltax += $products->gst * $request->quantity[$i];
                $totalgross += $products->price * $request->quantity[$i];
                $i++;
            }
        }
        $re = AppSettings::findorfail(1);
        $servicein = ServiceIn::findorfail($id);
        if ($servicein->is_dealer == true && $servicein->is_renewal == true) {

            $toto = $totaltotal + $re->DealerRenewAmount;
        } else if ($servicein->is_dealer == false && $servicein->is_renewal == true) {
            $toto = $totaltotal + $re->CusomerRenewAmount;
        } else {
            $toto = $totaltotal;
        }
        $servicein->total = $toto;

        // $servicein->total = $totaltotal;
        $servicein->tax = $totaltax;
        $servicein->gross = $totalgross;
        $servicein->save();
        return redirect('index-production');
    }

    public function CustomerCareIndex()
    {
        return view('customercare.customercareindex');
    }


    public function GetIndexCustomerCare()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', '!=', 'delivered')->where('status', '!=', 'cancelled')->get();
        return response()->json(['service_in' => $service_in]);
    }



    public function GetServiceInById($id)
    {
        $service = ServiceIn::findorfail($id);
        return $service;
    }

    public function ProductionView($id)
    {
        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }

        return view('production.productionview')->with(['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }
    public function SimDetailsUpdate($id)
    {
        $servicein = ServiceIn::findorfail($id);
        $servicein->msisdn = request()->msisdn;
        $servicein->sim1 = request()->sim1;
        $servicein->sim2 = request()->sim2;
        $servicein->save();
        if ($servicein) {
            return response()->json(['status' => true, 'message' => 'Status Changed']);
        } else {
            return response()->json(['status' => false, 'message' => 'Somthing Went Wrong']);
        }
    }


    public function getimeilist(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $employees = gps::select('id', 'imei')->limit(5)->get();
        } else {
            $employees = gps::select('id', 'imei')->where('imei', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee->id,
                "text" => $employee->imei
            );
        }
        return response()->json($response);
    }




    public function invoice($id)
    {
        $servicein = ServiceIn::with(['particulars', 'particulars.products'])->findorfail($id);
        return view('invoice.invoice')->with(['servicein' => $servicein]);
    }

    public function deliverynote($id)
    {
        $servicein = ServiceIn::with(['particulars', 'particulars.products'])->findorfail($id);
        return view('print.deliverynote')->with(['servicein' => $servicein]);
    }




    public function servicecompleted($id)
    {
        $servicein = ServiceIn::findorfail($id);
        $servicein->status = 'completed';
        $servicein->save();
        return redirect('service');
    }
    public function getserial($imei)
    {
        $imeis = gps::where('imei', $imei)->get();
        return $imeis->first();
    }
    public function courierlist()
    {
        return view('Servicer::courierlist');
    }
    public function getcourierlist(Request $request)
    {
       if ($request->input('start_transactions') && $request->input('end_transactions')) {
                $start_date = Carbon::parse($request->input('start_transactions') . ' 00:00:00.000000');
                $end_date = Carbon::parse($request->input('end_transactions') . ' 23:59:59.999999');
                $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'delivered')->whereBetween('delivery_date', [$start_date, $end_date])->with(['type'])->get();
            } else {
                $start_date = Carbon::now()->toDateString() . ' 00:00:00.000000';
                $end_date =  Carbon::now()->toDateString()  . ' 23:59:59.999999';
                $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'delivered')->whereBetween('delivery_date', [$start_date, $end_date])->with(['type'])->get();
        }
    
        return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('date', function ($service_in) { 
           return   date('Y-m-d', strtotime($service_in->date));
        })
        ->addColumn('delivery_date', function ($service_in) { 
            return   date('Y-m-d', strtotime($service_in->date));
         })
         ->addColumn('service_center_id', function ($service_in) { 
            if($service_in->service_center_id){
                return  $service_in->ServiceCenter->name;
            }else{
                return '---';
            }
          
         })
         
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');

            if ($service_in->status == 'servicein') {



                // <a onclick="sendservice('+data.id+',`sendtoservice`)" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>

               return '
                    <a class="btn btn-light-grey btn-xs text-black" href="'.$b_url.'/edit-service-in-view/' .$service_in->id
                    .
                    '" ><i class="fa fa-edit"></i></a><a data-toggle="modal"  data-target="#myModal" onclick="setvalue(' .
                    $service_in->id.
                    ')" class="btn btn-light-grey btn-xs text-black"><i class="fa fa-paper-plane" aria-hidden="true"></i></a><a style="margin-right:3%;" class="btn btn-light-grey btn-xs text-black" onclick="deletes('.
                    $service_in->id. ')"  value="Delete"><i class="fa fa-trash"></i></a>';
            } else {
            return "
                <a href=".$b_url."/view-device-details/".$service_in->id."  class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
               

            }
            return "
            <a href=".$b_url."/view-device-details/".$service_in->id."  class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
         

        })
        ->rawColumns(['link', 'action'])
        ->make();
    }
    public function simrenewal()
    {
        return view('service.simrenewal');
    }
    public function getsimrenewal(Request $request)
    {
        if ($request->ajax()) {

            if ($request->input('start_transactions') && $request->input('end_transactions')) {
                $start_date = Carbon::parse($request->input('start_transactions') . ' 00:00:00.000000');
                $end_date = Carbon::parse($request->input('end_transactions') . ' 23:59:59.999999');
                $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_renewal', true)->with(['type'])->whereBetween('date', [$start_date, $end_date])->get();
            } else {

                $start_date = Carbon::now()->toDateString() . ' 00:00:00.000000';
                $end_date =  Carbon::now()->toDateString()  . ' 23:59:59.999999';
                $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_renewal', true)->with(['type'])->whereBetween('date', [$start_date, $end_date])->get();
            }
        } else {
            abort(403);
        }
        return response()->json(['service_in' => $service_in]);
    }
    public function paidanddelivered($id)
    {
        $servicein = ServiceIn::findorfail($id);
        return view('service.paidanddelivered')->with(['servicein' => $servicein]);
    }
    public function paid()
    {
        return view('service.paid');
    }
    public function getpaid()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_paid', true)->get();
        return response()->json(['service_in' => $service_in]);
    }
    public function getdeliveryaddress($id)
    {
        $servicein = ServiceIn::findorfail($id);
        return $servicein;
    }
    public function adddeliverydetails(Request $request)
    {
        $servicein = ServiceIn::findorfail($request->ids);
        $servicein->customer_name = $request->customer_name;
        $servicein->deliveryadddress = $request->deliveryaddress;
        $servicein->deliveryservice = $request->deliveryservice;
        $servicein->deliverydetails = $request->description;
        $servicein->delivery_date = Carbon::now()->toDateTimeString();
        $servicein->status = 'delivered';
        $save =   $servicein->save();
        $message = "Dear Customer,
      Your GPS device has been dispatched after service.
      VST Mobility Solutions.";
        $template_id = "1107166788738261599";
        if ($save) {
        //    (new SendSmsController)->sendmessage($message, $servicein->customermobile, $template_id);
        }
        return redirect('deliveredview');
    }
    public function customercareview($id)
    {

        $servicein = ServiceIn::with(['type'])->with(['particulars', 'particulars.products'])->findorfail($id);
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }
        return view('Servicer::customercareview')->with(['servicein' => $servicein, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }
    public function servicepaymentreceived()
    {
        return view('service.paymentreceived');
    }
    public function getpaymentrecieved()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'delivered')->orWhere('status', 'completed')->get();
        return response()->json(['service_in' => $service_in]);
    }
    public function deliveredview()
    {
        return view('Servicer::deliverd');
    }

    public function servicedeliverd(Request $request)
    {


        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'sendtodelivery')->get();
       
        return DataTables::of($service_in)
        ->addIndexColumn()
        ->addColumn('date', function ($service_in) { 
           return   date('Y-m-d', strtotime($service_in->date));;
        })
        ->addColumn('status', function ($service_in) { 

            if ($service_in->status=='servicein') {
               return "Service";

            } if ($service_in->status=='sendtoservice')
            {
                return "Service";
               
            }else if ($service_in->status=='sendtocustomercare')
            {
                return "Customer Care";
            
            }else  if ($service_in->status=='sendtodelivery')
            {
                return "Delivery";
               
            }
            else  if ($service_in->status=='delivered')
            {
                return "Delivered";
               
            }
            else  if ($service_in->status== 'completed') {
                return "Completed";
            }else  if ($service_in->status== 'customerapproved') {
                return "Approved";
               
            }})
        ->addColumn('action', function ($service_in) {

            $b_url = \URL::to('/');$a='';
               //  $a= "<a class='btn btn-light-grey btn-xs text-black' href=".$b_url."/customercareview/" .$service_in->id. " <i class='fa fa-eye'></i></a>";
              
               if ($service_in->status!='delivered'){
                 $a.= '<a style="margin-left:3%;" class="btn btn-primary" data-toggle="modal"  data-target="#myModal" onclick="deliveryaddress(' .
                    $service_in->id. ')"  type="button">Send</a>
                </a>';
               }
          
           $a.=" <a href=".$b_url."/view-device-details/".$service_in->id."  class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
         return $a;

        })
        ->rawColumns(['link', 'action'])
        ->make();
      
   
    }
   
    public function cancelledview()
    {
        return view('service.cancelled');
    }
    public function servicecancelled()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'cancelled')->get();
        return response()->json(['service_in' => $service_in]);
    }
    public function invoice_created()
    {

        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'invoicecreated')->get();
        return response()->json(['service_in' => $service_in]);
    }

    public function invoicecreated()
    {
        return view('service.invoicecreated');
    }
    public function createinvoice($id, Request $request)
    {
        $servicein = ServiceIn::findorfail($id);
        //  $servicein->status = 'paymentreceived';
        $servicein->payment_type = $request->payment_type;
        $servicein->discount = $request->discount;
        $servicein->paid_amount = $request->amount;
        $servicein->reference_no = $request->reference_no;
        $servicein->payment_date = Carbon::now()->toDateTimeString();
        $servicein->is_paid = true;
        $servicein->save();
        $complaint_type = Complaint::get();
        $products = Component::get();
        return redirect('customerapproved');
        // return view('service.createinvoice')->with(['servicein' => $servicein, 'complaint_type' => $complaint_type, 'products' => $products]);
    }
    public function createinvoiceview($id)
    {
        $servicein = ServiceIn::findorfail($id);
        $complaint_type = Complaint::get();
        $products = Component::get();
        $appsettings = AppSettings::findorfail(1);
        if ($servicein->is_renewal == true && $servicein->is_dealer == true) {
            $renewalcharge = $appsettings->DealerRenewAmount;
        } else if ($servicein->is_renewal == true && $servicein->is_dealer == false) {
            $renewalcharge = $appsettings->CusomerRenewAmount;
        } else {
            $renewalcharge = 0;
        }

        return view('service.createinvoice')->with(['servicein' => $servicein, 'complaint_type' => $complaint_type, 'products' => $products, 'renewalcharge' => $renewalcharge]);
    }
    public function customerapproved()
    {
        return view('service.customerapproved');
    }
    public function customer_approved()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', '!=', 'paymentreceived')->Where('is_paid', false)->get();
        return response()->json(['service_in' => $service_in]);
    }
    public function customerapprove($id)
    {
        $servicein = ServiceIn::findorfail($id);
        $servicein->status = 'customerapproved';
        $servicein->save();
        return redirect('index-customer-care');
    }
    public function customercancelled($id)
    {
        $servicein = ServiceIn::findorfail($id);
        $servicein->status = 'cancelled';
        $servicein->save();
        return redirect('index-customer-care');
    }
    public function getallsendtocustomercare()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'sendtocustomercare')->get();
        return response()->json(['service_in' => $service_in]);
    }
    public function getsendtocustomercare()
    {
        return view('service.sendtocustomercare');
    }

    public function addcomponents()
    {
        return view('service.addcomponents');
    }
    public function index()
    {
        return view('service.index');
    }
    public function getallservicein()
    {
        $service_in = ServiceIn::orderby('created_at', 'desc')->where('status', 'sendtoservice')->orWhere('status', 'customerapproved')->get();
        return response()->json(['service_in' => $service_in]);
    }

    public function add()
    {
        $complaint_type = Complaint::get();
        $service_in = ServiceIn::get();

        if (count($service_in) != 0) {
            $EntryNumber = $this->entry($service_in->last()->id);
        } else {
            $EntryNumber = 'SRV-0001';
        }

        $imeis = gps::get();


        return view('service.service_in')->with(['complaint_type' => $complaint_type, 'entry_no' => $EntryNumber, 'imeis' => $imeis]);
    }
    public function entry($id)
    {
        $val = $id + 1;
        $EntryNumber = "SRV-000" . $val;

        return $EntryNumber;
    }
    public function store(Request $request)
    {
        if ($request->warranty == '') {
            $warranty = 0;
        } else {
            $warranty = 1;
        }
        if ($request->warranty == '') {
            $renewal = 0;
        } else {
            $renewal = 1;
        }

        $service = new ServiceIn();
        $service->date = Carbon::parse($request->date)->toDateTimeString();
        $service->installation_date = Carbon::parse($request->instalationdate)->toDateTimeString();
        $service->warranty = $warranty;
        $service->is_renewal = $renewal;
        $service->vehicle_no = $request->vehicle_no;
        $service->serial_no = $request->slno;
        $service->entry_no = $request->entry_no;
        $service->imei = $request->imei;
        $service->customer_name = $request->customername;
        $service->address = $request->address;
        $service->customermobile = $request->customermobile;
        $service->dealermobile = $request->dealermobile;
        $service->dealer_name = $request->dealername;
        $service->complaint_type = $request->complaint_type;
        $service->comments = $request->comments;
        $service->msisdn = $request->msisdn;
        $service->sim1 = $request->sim1;
        $service->sim2 = $request->sim2;
        $service->save();
        return redirect('service');
    }
    public function delete($id)
    {
        $delet = ServiceIn::findorfail($id)->delete();

        if ($delet) {
            return response()->json(['status' => true], 200);
        } else {
            return response()->json(['status' => false], 200);
        }
    }
    public function edit($id)
    {
        $imeis = gps::get();
        $complaint_type = Complaint::get();
        $servicein = ServiceIn::findorfail($id);
        return view('service.EditServiceIn')->with(['servicein' => $servicein, 'complaint_type' => $complaint_type, 'imeis' => $imeis]);
    }
    public function update($id, Request $request)
    {
        if ($request->warranty == '') {
            $warranty = 0;
        } else {
            $warranty = 1;
        }
        if ($request->warranty == '') {
            $renewal = 0;
        } else {
            $renewal = 1;
        }
        $service = ServiceIn::findorfail($id);
        $service->date = Carbon::parse($request->date)->toDateTimeString();
        $service->installation_date = Carbon::parse($request->instalationdate)->toDateTimeString();
        $service->warranty = $warranty;
        $service->is_renewal = $renewal;
        $service->vehicle_no = $request->vehicle_no;
        $service->serial_no = $request->slno;
        $service->entry_no = $request->entry_no;
        $service->imei = $request->imei;
        $service->customer_name = $request->customername;
        $service->address = $request->address;
        $service->customermobile = $request->customermobile;
        $service->dealermobile = $request->dealermobile;
        $service->dealer_name = $request->dealername;
        $service->complaint_type = $request->complaint_type;
        $service->comments = $request->comments;
        $service->msisdn = $request->msisdn;
        $service->sim1 = $request->sim1;
        $service->sim2 = $request->sim2;
        $service->save();
        return redirect('service');
    }
    public function servicelist()
    {


        return view('service.servicelist');
    }
    public function getservicelist(Request $request)

    {
        // dd($request->input('start_transactions'));
        if ($request->ajax()) {

            if ($request->input('start_transactions') && $request->input('end_transactions')) {
                $start_date = Carbon::parse($request->input('start_transactions') . ' 00:00:00.000000');
                $end_date = Carbon::parse($request->input('end_transactions') . ' 23:59:59.999999');
                $service_in = ServiceIn::orderby('created_at', 'desc')->whereBetween('date', [$start_date, $end_date])->with(['type'])->get();
            } else {
                $start_date = Carbon::now()->toDateString() . ' 00:00:00.000000';
                $end_date =  Carbon::now()->toDateString()  . ' 23:59:59.999999';
                $service_in = ServiceIn::orderby('created_at', 'desc')->whereBetween('date', [$start_date, $end_date])->with(['type'])->get();
            }
        } else {
            abort(403);
        }

        return response()->json(['service_in' => $service_in]);
    }
    public function paymentcollection()
    {
        return view('service.paymentcollection');
    }

    public function getpaymentcollection(Request $request)
    {
        if ($request->ajax()) {

            if ($request->input('start_transactions') && $request->input('end_transactions')) {
                $start_date = Carbon::parse($request->input('start_transactions') . ' 00:00:00.000000');
                $end_date = Carbon::parse($request->input('end_transactions') . ' 23:59:59.999999');

                $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_paid', true)->whereBetween('payment_date', [$start_date, $end_date])->get();
                $totalamount = $service_in->sum('total');
                $paid_amount = $service_in->sum('paid_amount');
                $totalgross = $service_in->sum('gross');
                $totaldiscount = $service_in->sum('discount');
            } else {
                $start_date = Carbon::now()->toDateString() . ' 00:00:00.000000';
                $end_date =  Carbon::now()->toDateString()  . ' 23:59:59.999999';

                $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_paid', true)->whereBetween('payment_date', [$start_date, $end_date])->get();
                $totalamount = $service_in->sum('total');
                $paid_amount = $service_in->sum('paid_amount');
                $totalgross = $service_in->sum('gross');
                $totaldiscount = $service_in->sum('discount');
            }

            return response()->json(['service_in' => $service_in, 'totalamount' => $totalamount, 'totalgross' => $totalgross, 'paidamount' => $paid_amount, 'totaldiscount' => $totaldiscount]);
        } else {
            abort(403);
        }
    }


    
    public function postServiceCenter(Request $request)
    {
        // dd(123456);
        $service = new ServiceCenter();    
        $service->name = $request->name;
        $service->address = $request->address;
        $service->location = $request->location;
        $service->country_id = $request->country_id;   
        $service->state_id = $request->state_id;
        $service->city_id = $request->city_id;
        $service->latitude = $request->latitude;
        $service->longitude = $request->longitude;
        $save = $service->save();
        return redirect('index-service-in');
    }


    public function postNewStore(Request $request)
    {
        // dd(123456);
        $service = new ServiceStore();    
        $service->name = $request->name;
        $service->address = $request->address;
        $service->location = $request->location;
        $service->country_id = $request->country_id;   
        $service->state_id = $request->state_id;
        $service->city_id = $request->city_id;
        $service->latitude = $request->latitude;
        $service->longitude = $request->longitude;
        $save = $service->save();
        return redirect('list-stores');
    }
}