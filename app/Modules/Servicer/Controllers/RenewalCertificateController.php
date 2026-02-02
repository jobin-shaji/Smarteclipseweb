<?php

namespace App\Modules\Servicer\Controllers;

use App\Models\gps;
use App\Models\RenewalCertificate;
use App\Models\ServiceIn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RenewalCertificateController extends Controller
{
    public function RenewalIndex()
    {
        return view('renewal.renewalindex');
    }
    public function GetIndexRenewal(Request $request)
    {
        if ($request->ajax()) {

            if ($request->input('start_transactions') && $request->input('end_transactions')) {
                $start_date = Carbon::parse($request->input('start_transactions') . ' 00:00:00.000000')->toDateTimeString();
                $end_date = Carbon::parse($request->input('end_transactions') . ' 23:59:59.999999')->toDateTimeString();
                $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_renewal', true)->with(['type', 'renewalcert'])->whereBetween('date', [$start_date, $end_date])->get();
            } else {

                // $start_date = Carbon::now()->toDateString() . ' 00:00:00.000000';
                // $end_date =  Carbon::now()->toDateString()  . ' 23:59:59.999999';
                $service_in = ServiceIn::orderby('created_at', 'desc')->where('is_renewal', true)->with(['type', 'renewalcert'])->get();
            }
        } else {
            abort(403);
        }
        return response()->json(['service_in' => $service_in]);
    }
    public function CreateCertificateView($id)
    {
        $service = ServiceIn::findorfail($id);
        $imeidetails = gps::where('imei', $service->imei)->get()->first();
        return view('renewal.createcertificate')->with(['device' => $service, 'imeidetails' => $imeidetails]);
    }
    public function GenerateCertificate(Request $request, $id)
    {

        $renewal = new RenewalCertificate();
        $renewal->service_in_id = $id;
        $renewal->deviceName = $request->devicename;
        $renewal->modelName = $request->model;
        $renewal->imei = $request->imei;
        $renewal->VLTD_ID_No = $request->serial;
        $renewal->NAME_OF_OWNER = $request->customername;
        $renewal->MOBILE_NUMBER = $request->mobile;
        $renewal->CHASSIS_NUMBER = $request->chassiss;
        $renewal->VEHICLE_No = $request->vehicle_number;
        $renewal->Date_of_Renewal = Carbon::parse($request->Renewaldate)->toDateTimeString();
        $renewal->Valid_Up_to = Carbon::parse($request->validupto)->toDateTimeString();
        $renewal->RTO = $request->RTO;
        $renewal->save();
        return redirect('index-renewal-certificate');
        // $service = ServiceIn::findorfail($id);
        // $imeidetails = gps::where('imei', $service->imei)->get()->first();

        // return view('renewal.certificate')->with(['device' => $service, 'imeidetails' => $imeidetails,'renewal'=>$renewal]);
    }




    public function Downloadcert($id)
    {
        $service = ServiceIn::with(['type', 'renewalcert'])->findorfail($id);
        $imeidetails = gps::where('imei', $service->imei)->get()->first();
        $renewal = $service->renewalcert;

        return view('renewal.certificate')->with(['device' => $service, 'imeidetails' => $imeidetails, 'renewal' => $renewal]);
    }
}
