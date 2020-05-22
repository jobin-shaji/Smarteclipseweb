<?php


namespace App\Modules\Warehouse\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Gps\Models\GpsLocation;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\GpsLog;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\Ota\Models\OtaType;
use App\Modules\Gps\Models\VltData;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Client\Models\Client;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Root\Models\Root;
use App\Modules\User\Models\User;
use App\Modules\Trader\Models\Trader;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

use Carbon\Carbon;
use DB;

use PDF;
use Auth;
use DataTables;

class WarehouseController extends Controller {

    /////////////////////////New Arrivals-start//////////////////////////////////

    //Display new arrived dealer gps
    public function newGpsDealerListPage()
    {
        return view('Warehouse::gps-dealer-new-arrival-list');
    }

    //returns new arrived gps as json
    public function getNewGpsDealer()
    {
        $user_id=\Auth::user()->id;
        $devices=GpsTransfer::select(
            'id',
            'from_user_id',
            'dispatched_on',
            'accepted_on'
        )
        ->with('fromUser:id,username')
        ->where('to_user_id',$user_id)
        ->with('gpsTransferItems')
        ->orderBy('id','DESC')
        ->get();
        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('count',function($gps_transfer){
                return $gps_transfer->gpsTransferItems->count();
             })
            ->addColumn('action', function ($devices) {
                $b_url = \URL::to('/');
                if($devices->accepted_on == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-info' data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'> View</i></a>
                    <button onclick=acceptDealerGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>";
                }else{
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-success'  data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'></i> View </a>
                    <b style='color:#008000';>Accepted</b>";
                }
               
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //Display new arrived sub dealer gps
    public function newGpsSubDealerListPage()
    {
        return view('Warehouse::gps-sub-dealer-new-arrival-list');
    }

    //returns new arrived gps as json
    public function getNewGpsSubDealer()
    {
        $user_id=\Auth::user()->id;
        $devices=GpsTransfer::select(
            'id',
            'from_user_id',
            'dispatched_on',
            'accepted_on'
        )
        ->with('fromUser:id,username')
        ->where('to_user_id',$user_id)
        ->with('gpsTransferItems')
        ->orderBy('id','DESC')
        ->get();
        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('count',function($gps_transfer){
                return $gps_transfer->gpsTransferItems->count();
             })
            ->addColumn('action', function ($devices) {
                $b_url = \URL::to('/');
                if($devices->accepted_on == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-info' data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'> View</i></a>
                    <button onclick=acceptSubDealerGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>";
                }else{
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-success'  data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'></i> View </a>
                    <b style='color:#008000';>Accepted</b>";
                }
               
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //Display new arrived trader gps from sub dealer
    public function newGpsTraderListPage()
    {
        return view('Warehouse::gps-trader-new-arrival-list');
    }

    //returns new arrived gps as json
    public function getNewGpsTraderList()
    {
        $user_id=\Auth::user()->id;
        $devices=GpsTransfer::select(
            'id',
            'from_user_id',
            'dispatched_on',
            'accepted_on'
        )
        ->with('fromUser:id,username')
        ->where('to_user_id',$user_id)
        ->with('gpsTransferItems')
        ->orderBy('id','DESC')
        ->get();
        return DataTables::of($devices)
            ->addIndexColumn()
            ->addColumn('count',function($gps_transfer){
                return $gps_transfer->gpsTransferItems->count();
             })
            ->addColumn('action', function ($devices) {
                $b_url = \URL::to('/');
                if($devices->accepted_on == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-info' data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'> View</i></a>
                    <button onclick=acceptTraderGpsTransfer(".$devices->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>";
                }else{
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($devices->id)."/view class='btn btn-xs btn-success'  data-toggle='tooltip' title='View  GPS'><i class='fas fa-eye'></i> View </a>
                    <b style='color:#008000';>Accepted</b>";
                }
               
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //////////////////////////New Arrivals-end////////////////////////////////

    ///////////////////////////Gps Transfer////////////////////////////////

    // gps transfer list - root
    public function getRootList()
    {
        return view('Warehouse::gps-transfer-root-list');
    }

    //get from user in dependent dropdown
    public function getFromListRoot(Request $request)
    {
        $transfer_type=$request->transfer_type;
        if($transfer_type == "1")
        {
            $from_users=Root::select('id','user_id','name')->withTrashed()->get();
        }
        else if($transfer_type == "2")
        {
            $from_users=Dealer::select('id','user_id','name')->withTrashed()->get();
        }
        else if($transfer_type == "3")
        {
            $from_users=SubDealer::select('id','user_id','name')->withTrashed()->get();
        }
        else if($transfer_type == "4")
        {
            $from_users=SubDealer::select('id','user_id','name')->withTrashed()->get();
        }
        else if($transfer_type == "5")
        {
            $from_users=Trader::select('id','user_id','name')->withTrashed()->get();
        }
        return response()->json($from_users);
    }

    //get to user in dependent dropdown
    public function getToListRoot(Request $request)
    {
        $transfer_type=$request->transfer_type;
        $from_user_id=$request->from_id;   
        if($transfer_type == "1")
        {
            $root = Root::select('id','user_id')->where('user_id',$from_user_id)->withTrashed()->first();
            $to_users=Dealer::select('id','user_id','name','root_id')->where("root_id",$root->id)->withTrashed()->get();
        }
        else if($transfer_type == "2")
        {
            if($from_user_id == '0')
            {
                $to_users=SubDealer::select('id','user_id','name','dealer_id')->withTrashed()->get();
            }
            else
            {
                $dealer = Dealer::select('id','user_id')->where('user_id',$from_user_id)->withTrashed()->first();
                $to_users=SubDealer::select('id','user_id','name','dealer_id')->where("dealer_id",$dealer->id)->withTrashed()->get();
            }
           
        }
        else if($transfer_type == "3")
        {
            if($from_user_id == '0')
            {
                $to_users=Client::select('id','user_id','name','sub_dealer_id')->whereNull('trader_id')->withTrashed()->get();
            }
            else
            {
                $sub_dealer = SubDealer::select('id','user_id')->where('user_id',$from_user_id)->withTrashed()->first();
                $to_users=Client::select('id','user_id','name','sub_dealer_id')->where("sub_dealer_id",$sub_dealer->id)->withTrashed()->get();
            }
        }
        else if($transfer_type == "4")
        {
            if($from_user_id == '0')
            {
                $to_users=Trader::select('id','user_id','name','sub_dealer_id')->withTrashed()->get();
            }
            else
            {
                $sub_dealer = SubDealer::select('id','user_id')->where('user_id',$from_user_id)->withTrashed()->first();
                $to_users=Trader::select('id','user_id','name','sub_dealer_id')->where("sub_dealer_id",$sub_dealer->id)->withTrashed()->get();
            }
        }
        else if($transfer_type == "5")
        {
            if($from_user_id == '0')
            {
                $to_users=Client::select('id','user_id','name','trader_id')->whereNull('sub_dealer_id')->withTrashed()->get();
            }
            else
            {
                $trader = Trader::select('id','user_id')->where('user_id',$from_user_id)->withTrashed()->first();
                $to_users=Client::select('id','user_id','name','trader_id')->where("trader_id",$trader->id)->withTrashed()->get();
            }
        }
        return response()->json($to_users);
    }

    //gps transfer list data - root
    public function getRootListData(Request $request)
    {
        $transfer_type      =   $request->data['transfer_type'];
        $from_user_id       =   $request->data['from_id'];
        $to_user_id         =   $request->data['to_id'];
        $from_date          =   date("Y-m-d", strtotime($request->data['from_date']));
        $to_date            =   date("Y-m-d", strtotime($request->data['to_date']));
        $gps_transfer       =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesBothAcceptedAndAwaitingConfirmationGps($from_date,$to_date);
        if($transfer_type   ==  '1')
        {
            $gps_transfer = $this->manufacturerToDistributorTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id);
            return DataTables::of($gps_transfer)
            ->addIndexColumn()
            ->addColumn('count', function ($gps_transfer)
            {
                return $gps_transfer->gpsTransferItems->count();
            })
            ->addColumn('action', function ($gps_transfer)
            {
                $b_url = \URL::to('/');
                if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer-root-manufacturer-distributor/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=cancelRootGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                    </button>";
                }
                else if($gps_transfer->deleted_at != null){
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#FF0000';>Cancelled</b>";
                }
                else{
                    return "
                    <a href=".$b_url."/gps-transfer-root-manufacturer-distributor/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transferred</b>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();

        }else if($transfer_type == '2')
        {
            $gps_transfer = $this->distributorToDealerTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id);
            return DataTables::of($gps_transfer)
            ->addIndexColumn()
            ->addColumn('count', function ($gps_transfer)
            {
                return $gps_transfer->gpsTransferItems->count();
            })
            ->addColumn('action', function ($gps_transfer)
            {
                $b_url = \URL::to('/');
                if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer-root-distributor-dealer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transfer In Progress</b>";
                }
                else if($gps_transfer->deleted_at != null){
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#FF0000';>Cancelled</b>";
                }
                else{
                    return "
                    <a href=".$b_url."/gps-transfer-root-distributor-dealer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transferred</b>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
        }
        else if($transfer_type == '3')
        {
            $gps_transfer = $this->dealerToClientTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id);
            return DataTables::of($gps_transfer)
            ->addIndexColumn()
            ->addColumn('count', function ($gps_transfer)
            {
                return $gps_transfer->gpsTransferItems->count();
            })
            ->addColumn('action', function ($gps_transfer)
            {
                $b_url = \URL::to('/');
                if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer-root-dealer-client/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transfer In Progress</b>";
                }
                else if($gps_transfer->deleted_at != null){
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#FF0000';>Cancelled</b>";
                }
                else{
                    return "
                    <a href=".$b_url."/gps-transfer-root-dealer-client/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transferred</b>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
        }
        else if($transfer_type == '4')
        {
            $gps_transfer = $this->dealerToSubDealerTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id);
            return DataTables::of($gps_transfer)
            ->addIndexColumn()
            ->addColumn('count', function ($gps_transfer)
            {
                return $gps_transfer->gpsTransferItems->count();
            })
            ->addColumn('action', function ($gps_transfer)
            {
                $b_url = \URL::to('/');
                if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer-root-sub-dealer-trader/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transfer In Progress</b>";
                }
                else if($gps_transfer->deleted_at != null){
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#FF0000';>Cancelled</b>";
                }
                else{
                    return "
                    <a href=".$b_url."/gps-transfer-root-sub-dealer-trader/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transferred</b>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
        }
        else if($transfer_type == '5')
        {
            $gps_transfer = $this->subDealerToClientTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id);
            return DataTables::of($gps_transfer)
            ->addIndexColumn()
            ->addColumn('count', function ($gps_transfer)
            {
                return $gps_transfer->gpsTransferItems->count();
            })
            ->addColumn('action', function ($gps_transfer)
            {
                $b_url = \URL::to('/');
                if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
                {
                    return "
                    <a href=".$b_url."/gps-transfer-root-trader-end-user/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transfer In Progress</b>";
                }
                else if($gps_transfer->deleted_at != null){
                    return "
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#FF0000';>Cancelled</b>";
                }
                else{
                    return "
                    <a href=".$b_url."/gps-transfer-root-trader-end-user/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                    <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <b style='color:#008000';>Transferred</b>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
        }
    }

    public function manufacturerToDistributorTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id)
    {
        if($to_user_id == '0')
        {
            $all_distributors = Dealer::withTrashed()->get();
            $distributors=[];
            foreach ($all_distributors as $distributor) {
                $distributors[]=$distributor->user_id;
            }
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->whereIn('to_user_id',$distributors)->get();
        }
        else
        {
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->where('to_user_id',$to_user_id)->get();
        }
        return $gps_transfer;
    }

    public function distributorToDealerTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id)
    {
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_distributors = Dealer::withTrashed()->get();
            $distributors=[];
            foreach ($all_distributors as $distributor) {
                $distributors[]=$distributor->user_id;
            }
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$distributors)->whereIn('to_user_id',$dealers)->get();
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->whereIn('to_user_id',$dealers)->get();
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_distributors = Dealer::withTrashed()->get();
            $distributors=[];
            foreach ($all_distributors as $distributor) {
                $distributors[]=$distributor->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$distributors)->where('to_user_id',$to_user_id)->get();
        }
        else
        {
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->where('to_user_id',$to_user_id)->get();
        }
        return $gps_transfer;
    }

    public function dealerToClientTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id)
    {
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $all_clients = Client::whereNull('trader_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$dealers)->whereIn('to_user_id',$clients)->get();
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_clients = Client::whereNull('trader_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->whereIn('to_user_id',$clients)->get();
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$dealers)->where('to_user_id',$to_user_id)->get();
        }
        else
        {
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->where('to_user_id',$to_user_id)->get();
        }
        return $gps_transfer;
    }

    public function dealerToSubDealerTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id)
    {
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$dealers)->whereIn('to_user_id',$sub_dealers)->get();
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->whereIn('to_user_id',$sub_dealers)->get();
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$dealers)->where('to_user_id',$to_user_id)->get();
        }
        else
        {
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->where('to_user_id',$to_user_id)->get();
        }
        return $gps_transfer;
    }

    public function subDealerToClientTransferredListInRoot($gps_transfer,$from_user_id,$to_user_id)
    {
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $all_clients = Client::whereNull('sub_dealer_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$sub_dealers)->whereIn('to_user_id',$clients)->get();
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_clients = Client::whereNull('sub_dealer_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->whereIn('to_user_id',$clients)->get();
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $gps_transfer = $gps_transfer->whereIn('from_user_id',$sub_dealers)->where('to_user_id',$to_user_id)->get();
        }
        else
        {
            $gps_transfer = $gps_transfer->where('from_user_id',$from_user_id)->where('to_user_id',$to_user_id)->get();
        }
        return $gps_transfer;
    }

    public function getTotalTransferredCount(Request $request)
    {
        $transfer_type      =   $request['transfer_type'];
        $from_user_id       =   $request['from_id'];
        $to_user_id         =   $request['to_id'];
        $from_date          =   date("Y-m-d", strtotime($request['from_date']));
        $to_date            =   date("Y-m-d", strtotime($request['to_date']));
        
        if($transfer_type == 1)
        {
            $transferred_string = $this->manufacturerToDistributorTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date);
        }
        else if($transfer_type == 2)
        {
            $transferred_string = $this->distributorToDealerTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date);
        }
        else if($transfer_type == 3)
        {
            $transferred_string = $this->dealerToClientTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date);
        }
        else if($transfer_type == 4)
        {
            $transferred_string = $this->dealerToSubDealerTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date);
        }
        else if($transfer_type == 5)
        {
            $transferred_string = $this->subDealerToClientTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date);
        }
        
        return response()->json($transferred_string);
    }

    public function manufacturerToDistributorTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date)
    {
        $from_user_details                  =   Root::where('user_id',$from_user_id)->withTrashed()->first();
        if($to_user_id == '0')
        {
            $all_distributors               =   Dealer::withTrashed()->get();
            $distributors                   =   [];
            foreach ($all_distributors as $distributor) {
                $distributors[]             =   $distributor->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps([$from_user_id],$distributors,$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],$distributors,$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else
        {
            $to_user_details                        =    Dealer::where('user_id',$to_user_id)->withTrashed()->first();
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps([$from_user_id],[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $stock_in_distributor                   =   GpsStock::select('dealer_id','subdealer_id')->where('dealer_id',$to_user_details->id)->whereNull('subdealer_id')->count();
            if($stock_in_distributor > 1) {
                $stock_string = 'Devices In Stock With <b>'.$to_user_details->name;
            }else{
                $stock_string = 'Device In Stock With <b>'.$to_user_details->name;
            }
           
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                'instock_gps_count'                 =>  $stock_in_distributor,
                'stock_string'                      =>  $stock_string
                ];
        }
        return $transferred_data;
    }

    public function distributorToDealerTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date)
    {
        if($from_user_id)
        {
            $from_user_details = Dealer::where('user_id',$from_user_id)->withTrashed()->first();
        }
        if($to_user_id)
        {
            $to_user_details = SubDealer::where('user_id',$to_user_id)->withTrashed()->first();
        }
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_distributors = Dealer::withTrashed()->get();
            $distributors=[];
            foreach ($all_distributors as $distributor) {
                $distributors[]=$distributor->user_id;
            }
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps($distributors,$dealers,$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($distributors,$dealers,$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps([$from_user_id],$dealers,$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],$dealers,$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_distributors = Dealer::withTrashed()->get();
            $distributors=[];
            foreach ($all_distributors as $distributor) {
                $distributors[]=$distributor->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps($distributors,[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($distributors,[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else
        {
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps([$from_user_id],[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $stock_in_dealer=GpsStock::select('subdealer_id','client_id')->where('subdealer_id',$to_user_details->id)->whereNull('client_id')->count();
           
            if($stock_in_dealer > 1) {
                $stock_string = 'Devices In Stock With <b>'.$to_user_details->name;
            }else{
                $stock_string = 'Device In Stock With <b>'.$to_user_details->name;
            }
           
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                'instock_gps_count'                 =>  $stock_in_dealer,
                'stock_string'                      =>  $stock_string,
                ];
        }
        return $transferred_data;
    }

    public function dealerToClientTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date)
    {
        if($from_user_id)
        {
            $from_user_details = SubDealer::where('user_id',$from_user_id)->withTrashed()->first();
        }
        if($to_user_id)
        {
            $to_user_details = Client::where('user_id',$to_user_id)->withTrashed()->first();
        }
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $all_clients = Client::whereNull('trader_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($dealers,$clients,$from_date,$to_date);      
            
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_clients = Client::whereNull('trader_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],$clients,$from_date,$to_date);
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($dealers,[$to_user_id],$from_date,$to_date);
        }
        else
        {
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],[$to_user_id],$from_date,$to_date);
        }
        if($gps_transfers_accepted > 1) 
        {
            $transferred_string             = 'Devices Transferred';
        }else
        {
            $transferred_string             = 'Device Transferred';
        }
        $transferred_data = [
            'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
            'transferred_string'                =>  $transferred_string
            ];
        return $transferred_data;
    }

    public function dealerToSubDealerTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date)
    {
        if($from_user_id)
        {
            $from_user_details = SubDealer::where('user_id',$from_user_id)->withTrashed()->first();
        }
        if($to_user_id)
        {
            $to_user_details = Trader::where('user_id',$to_user_id)->withTrashed()->first();
        }
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps($dealers,$sub_dealers,$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($dealers,$sub_dealers,$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps([$from_user_id],$sub_dealers,$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],$sub_dealers,$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_dealers = SubDealer::withTrashed()->get();
            $dealers=[];
            foreach ($all_dealers as $dealer) {
                $dealers[]=$dealer->user_id;
            }
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps($dealers,[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($dealers,[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                ];
        }
        else
        {
            $gps_transfers_awaiting_confirmation    =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps([$from_user_id],[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_awaiting_confirmation > 1) {
                $awaiting_confirmation_string = 'Devices Waiting For Confirmation';
            }else{
                $awaiting_confirmation_string = 'Device Waiting For Confirmation';
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],[$to_user_id],$from_date,$to_date);      
            if($gps_transfers_accepted > 1) {
                $transferred_string = 'Devices Transferred';
            }else{
                $transferred_string = 'Device Transferred';
            }
            $stock_in_sub_dealer=GpsStock::select('id','trader_id','client_id')->where('trader_id',$to_user_details->id)->whereNull('client_id')->count();
           
            if($stock_in_sub_dealer > 1) {
                $stock_string = 'Devices In Stock With <b>'.$to_user_details->name;
            }else{
                $stock_string = 'Device In Stock With <b>'.$to_user_details->name;
            }
            
            $transferred_data = [
                'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
                'transferred_string'                =>  $transferred_string,
                'awaiting_confirmation_gps_count'   =>  $gps_transfers_awaiting_confirmation[0]->count,
                'awaiting_confirmation_string'      =>  $awaiting_confirmation_string,
                'instock_gps_count'                 =>  $stock_in_sub_dealer,
                'stock_string'                      =>  $stock_string
                ];
        }
        return $transferred_data;
    }

    public function subDealerToClientTransferredCountInRoot($from_user_id,$to_user_id,$from_date,$to_date)
    {
        if($from_user_id)
        {
            $from_user_details = Trader::where('user_id',$from_user_id)->withTrashed()->first();
        }
        if($to_user_id)
        {
            $to_user_details = Client::where('user_id',$to_user_id)->withTrashed()->first();
        }
        if($from_user_id == '0' && $to_user_id == '0')
        {
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $all_clients = Client::whereNull('sub_dealer_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($sub_dealers,$clients,$from_date,$to_date);
        }
        else if($from_user_id != '0' && $to_user_id == '0')
        {
            $all_clients = Client::whereNull('sub_dealer_id')->withTrashed()->get();
            $clients=[];
            foreach ($all_clients as $client) {
                $clients[]=$client->user_id;
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],$clients,$from_date,$to_date);
        }
        else if($from_user_id == '0' && $to_user_id != '0')
        {
            $all_sub_dealers = Trader::withTrashed()->get();
            $sub_dealers=[];
            foreach ($all_sub_dealers as $sub_dealer) {
                $sub_dealers[]=$sub_dealer->user_id;
            }
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($sub_dealers,[$to_user_id],$from_date,$to_date);
        }
        else
        {
            $gps_transfers_accepted                 =   (new GpsTransfer())->getTransferredGpsDetailsWhichIncludesTransferAcceptedGps([$from_user_id],[$to_user_id],$from_date,$to_date);
        }
        if($gps_transfers_accepted > 1) 
        {
            $transferred_string                     = 'Devices Transferred';
        }else
        {
            $transferred_string                     = 'Device Transferred';
        }
        $transferred_data = [
            'transferred_gps_count'             =>  $gps_transfers_accepted[0]->count,
            'transferred_string'                =>  $transferred_string
            ];
        return $transferred_data;
    }

    // create root gps transfer
    public function createRootGpsTransfer(Request $request)
    {
        $user = \Auth::user();
        $root = $user->root;
        $devices = GpsStock::select('id', 'gps_id','dealer_id')
                        ->with('gps')
                        ->where('dealer_id',null)
                        ->get();
        $entities = $root->dealers;

        return view('Warehouse::root-gps-transfer', ['devices' => $devices,'entities' => $entities]);
    }

    //get scanned gps and check gps status
     public function removeaddlist(Request $request)
     {
        $gps_id= $request->gps_id;
        $user = \Auth::user();
        $device = Gps::select('id', 'serial_no','batch_number','employee_code')
                        ->where('id',$gps_id)
                        ->first();
         if($device != null)
        {
            GpsStock::where('gps_id',$device->id)->update(['device_to_transfer' => 0]);
            $device_in_stock = GpsStock::select('id','gps_id')->where('gps_id',$device->id)->first();
            if($device_in_stock != null)
            {
                if($user->hasRole('root'))
                {
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('device_to_transfer',0)->where('dealer_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                        ->where('dealer_id',null)->where('gps_id',$device->id)->count();
                    if($stock_devices != 0){
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'devices' => $device_added_to_transfer
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }
                else if($user->hasRole('dealer'))
                {
                    $dealer_id=$user->dealer->id;
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('dealer_id',$dealer_id)->where('device_to_transfer',0)->where('subdealer_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                        ->where('dealer_id',$dealer_id)->where('subdealer_id',null)->where('gps_id',$device->id)->count();
                    if($stock_devices != 0){
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'devices' => $device_added_to_transfer
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }
                else if($user->hasRole('sub_dealer'))
                {
                    $subdealer_id=$user->subdealer->id;
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('subdealer_id',$subdealer_id)->where('device_to_transfer',0)->where('client_id',null)->where('trader_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','subdealer_id','trader_id','client_id')
                        ->where('subdealer_id',$subdealer_id)->where('client_id',null)->where('trader_id',null)->where('gps_id',$device->id)->count();
                    if($stock_devices != 0){
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'devices' => $device_added_to_transfer
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }
                else if($user->hasRole('trader'))
                {
                    $trader_id=$user->trader->id;
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('trader_id',$trader_id)->where('device_to_transfer',0)->where('client_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','trader_id','client_id')
                        ->where('trader_id',$trader_id)->where('client_id',null)->where('gps_id',$device->id)->count();
                    if($stock_devices != 0){
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'devices' => $device_added_to_transfer
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }
            }
            else
            {
                return response()->json(array(
                    'status' => 2,
                    'message' => 'Device not found in stock',
                ));
            }
        }
        else
        {
            return response()->json(array(
                'status' => 0,
                'message' => 'Device not found',
            ));
        }
     }
    public function getScannedGps(Request $request)
    {
        $device_serial_no= trim($request->serial_no," ,\0,\n,\x0B,\r");
        $user = \Auth::user();
        $device = Gps::select('id', 'serial_no','batch_number','employee_code')
                        ->where('serial_no',$device_serial_no)
                        ->first();
        if($device != null)
        {
            GpsStock::where('gps_id',$device->id)->update(['device_to_transfer' => 1]);
            $device_in_stock = GpsStock::select('id','gps_id')->where('gps_id',$device->id)->first();
            if($device_in_stock != null)
            {
                if($user->hasRole('root'))
                {
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('device_to_transfer',0)->where('dealer_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','dealer_id')
                                    ->where('dealer_id',null)->where('gps_id',$device->id)->count();
                    if($stock_devices != 0){
                        $gps_id=$device->id;
                        $gps_serial_no=$device->serial_no;
                        $gps_batch_number=$device->batch_number;
                        $gps_employee_code=$device->employee_code;
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'gps_id' => $gps_id,
                            'gps_serial_no' => $gps_serial_no,
                            'gps_batch_number' => $gps_batch_number,
                            'gps_employee_code' => $gps_employee_code,
                            'devices' => $device_added_to_transfer
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }else if($user->hasRole('dealer')){
                    $dealer_id=$user->dealer->id;
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('dealer_id',$dealer_id)->where('device_to_transfer',0)->where('subdealer_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                        ->where('dealer_id',$dealer_id)->where('subdealer_id',null)->where('gps_id',$device->id)->count();
                    $non_accepted_devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                        ->where('dealer_id',0)->where('subdealer_id',null)->where('gps_id',$device->id)->count();
                    if($stock_devices != 0){
                        $gps_id=$device->id;
                        $gps_serial_no=$device->serial_no;
                        $gps_batch_number=$device->batch_number;
                        $gps_employee_code=$device->employee_code;
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'gps_id' => $gps_id,
                            'gps_serial_no' => $gps_serial_no,
                            'gps_batch_number' => $gps_batch_number,
                            'gps_employee_code' => $gps_employee_code,
                            'devices' => $device_added_to_transfer
                        ));
                    }else if( $non_accepted_devices != 0){
                        return response()->json(array(
                            'status' => 4,
                            'message' => 'Please accept this device for transaction',
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }

                }else if($user->hasRole('sub_dealer')){
                    $subdealer_id=$user->subdealer->id;
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('subdealer_id',$subdealer_id)->where('device_to_transfer',0)->where('client_id',null)->where('trader_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','subdealer_id','trader_id','client_id')
                        ->where('subdealer_id',$subdealer_id)->where('client_id',null)->where('trader_id',null)->where('gps_id',$device->id)->count();
                    $non_accepted_devices = GpsStock::select('id', 'gps_id','subdealer_id','trader_id','client_id')
                        ->where('subdealer_id',0)->where('client_id',null)->where('trader_id',null)->where('gps_id',$device->id)->count();

                    if($stock_devices != 0){
                        $gps_id=$device->id;
                        $gps_serial_no=$device->serial_no;
                        $gps_batch_number=$device->batch_number;
                        $gps_employee_code=$device->employee_code;
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'gps_id' => $gps_id,
                            'gps_serial_no' => $gps_serial_no,
                            'gps_batch_number' => $gps_batch_number,
                            'gps_employee_code' => $gps_employee_code,
                            'devices' => $device_added_to_transfer
                        ));
                    }else if( $non_accepted_devices != 0){
                        return response()->json(array(
                            'status' => 4,
                            'message' => 'Please accept this device for transaction',
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }else if($user->hasRole('trader')){
                    $trader_id=$user->trader->id;
                    $device_added_to_transfer = GpsStock::select('id','gps_id')->with('gps')->where('trader_id',$trader_id)->where('device_to_transfer',0)->where('client_id',null)->get();
                    $stock_devices = GpsStock::select('id', 'gps_id','trader_id','client_id')
                        ->where('trader_id',$trader_id)->where('client_id',null)->where('gps_id',$device->id)->count();
                    $non_accepted_devices = GpsStock::select('id', 'gps_id','trader_id','client_id')
                        ->where('trader_id',0)->where('client_id',null)->where('gps_id',$device->id)->count();

                    if($stock_devices != 0){
                        $gps_id=$device->id;
                        $gps_serial_no=$device->serial_no;
                        $gps_batch_number=$device->batch_number;
                        $gps_employee_code=$device->employee_code;
                        return response()->json(array(
                            'status' => 1,
                            'title' => 'success',
                            'gps_id' => $gps_id,
                            'gps_serial_no' => $gps_serial_no,
                            'gps_batch_number' => $gps_batch_number,
                            'gps_employee_code' => $gps_employee_code,
                            'devices' => $device_added_to_transfer
                        ));
                    }else if( $non_accepted_devices != 0){
                        return response()->json(array(
                            'status' => 4,
                            'message' => 'Please accept this device for transaction',
                        ));
                    }
                    else
                    {
                        return response()->json(array(
                            'status' => 3,
                            'message' => 'Device already transferred',
                        ));
                    }
                }
            }
            else
            {
                return response()->json(array(
                    'status' => 2,
                    'message' => 'Device not found in stock',
                ));
            }
        }
        else
        {
            return response()->json(array(
                'status' => 0,
                'message' => 'Device not found',
            ));
        }
    }

    //get address and mobile details based on dealer selection
    public function getDealerDetailsFromRoot(Request $request)
    {
        $dealer_user_id=$request->dealer_user_id;
        $dealer_user_detalis=User::find($dealer_user_id);
        $dealer_details = Dealer::select('id', 'name', 'address','user_id')
                        ->where('user_id',$dealer_user_id)
                        ->first();
        $dealer_name=$dealer_details->name;
        $dealer_address=$dealer_details->address;
        $dealer_mobile=$dealer_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'dealer_name' => $dealer_name,
              'dealer_address' => $dealer_address,
              'dealer_mobile' => $dealer_mobile
        ));
    }

    // proceed gps transfer for confirmation
    public function proceedRootGpsTransfer(Request $request)
    {
       
        if($request->gps_id[0]==null){
            $rules = $this->gpsRootTransferRule();
        }else{
            $rules = $this->gpsRootTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
        $dealer_user_id=$request->dealer_user_id;
        $dealer_name=$request->dealer_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $gps_array_list = $request->gps_id;
        $gps_arrays=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_arrays as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();

        foreach ($devices as $device) {
            $gps_array[]=$device->id;
        }

        // return view('Warehouse::root-gps-transfer_proceed', ['dealer_user_id' => $dealer_user_id,'dealer_name' => $dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);

        $from_user_id = \Auth::user()->id;
        $to_user_id = $dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')->whereNotNull('dealer_id')->whereIn('gps_id',$gps_array)->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps.transfer.root'));
        }else{
            $uniqid=uniqid();
            $order_number=$uniqid.date("Y-m-d h:i:s");
            if($gps_array){
                $gps_transfer = GpsTransfer::create([
                  "from_user_id" => $from_user_id,
                  "to_user_id" => $to_user_id,
                  "order_number" => $order_number,
                  "scanned_employee_code" => $scanned_employee_code,
                  "invoice_number" => $invoice_number,
                  "dispatched_on" => date('Y-m-d H:i:s')
                ]);
                $last_id_in_gps_transfer=$gps_transfer->id;
            }
            if($last_id_in_gps_transfer){
                foreach ($gps_array as $gps_id) {
                    $gps_transfer_item = GpsTransferItems::create([
                      "gps_id" => $gps_id,
                      "gps_transfer_id" => $last_id_in_gps_transfer
                    ]);
                    if($gps_transfer_item){
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->dealer_id =0;
                        $gps->device_to_transfer =0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'GPS Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
        }
    }

    // save root gps transfer/transfer gps from root to dealer
    // public function proceedConfirmRootGpsTransfer(Request $request)
    // {
    //     $from_user_id = \Auth::user()->id;
    //     $gps_array = $request->gps_id;
    //     $to_user_id = $request->dealer_user_id;
    //     $scanned_employee_code=$request->scanned_employee_code;
    //     $invoice_number=$request->invoice_number;
    //     $transferred_devices=[];
    //     $transfer_inprogress_devices = GpsStock::select('gps_id')->whereNotNull('dealer_id')->whereIn('gps_id',$gps_array)->get();
    //     foreach ($transfer_inprogress_devices as $devices) {
    //         $transferred_devices[]=$devices->gps_id;
    //     }
    //     if($transferred_devices){
    //         $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps.transfer.root'));
    //     }else{
    //         $uniqid=uniqid();
    //         $order_number=$uniqid.date("Y-m-d h:i:s");
    //         if($gps_array){
    //             $gps_transfer = GpsTransfer::create([
    //               "from_user_id" => $from_user_id,
    //               "to_user_id" => $to_user_id,
    //               "order_number" => $order_number,
    //               "scanned_employee_code" => $scanned_employee_code,
    //               "invoice_number" => $invoice_number,
    //               "dispatched_on" => date('Y-m-d H:i:s')
    //             ]);
    //             $last_id_in_gps_transfer=$gps_transfer->id;
    //         }
    //         if($last_id_in_gps_transfer){
    //             foreach ($gps_array as $gps_id) {
    //                 $gps_transfer_item = GpsTransferItems::create([
    //                   "gps_id" => $gps_id,
    //                   "gps_transfer_id" => $last_id_in_gps_transfer
    //                 ]);
    //                 if($gps_transfer_item){
    //                     //update gps stock table
    //                     $gps = GpsStock::where('gps_id',$gps_id)->first();
    //                     $gps->dealer_id =0;
    //                     $gps->save();
    //                 }
    //             }
    //         }
    //         $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
    //         $request->session()->flash('message', 'GPS Transfer successfully completed!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer.label',$encrypted_gps_transfer_id));
    //     }
       
    // }

    // gps transfer list - dealer
    public function getDealerList()
    {
        return view('Warehouse::gps-transfer-dealer-list');
    }

    //gps transfer list data - dealer
    public function getDealerListData(Request $request)
    {
        $user_id=\Auth::user()->id;
        $from_date=$request['from_date'];
        $to_date=$request['to_date'];
        $gps_transfer = GpsTransfer::select(
            'id',
            'from_user_id',
            'to_user_id',
            'dispatched_on',
            'accepted_on',
            'deleted_at'
            // \DB::raw('count(id) as count')
        )
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gpsTransferItems')
        ->where('from_user_id',$user_id)
        ->orderBy('id','DESC')
        ->withTrashed();
        if($from_date){
            $search_from_date=date("Y-m-d", strtotime($from_date));
            $search_to_date=date("Y-m-d", strtotime($to_date));
            $gps_transfer = $gps_transfer->whereDate('dispatched_on', '>=', $search_from_date)->whereDate('dispatched_on', '<=', $search_to_date);
        }
        $gps_transfer = $gps_transfer->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->addColumn('count', function ($gps_transfer)
        {
            return $gps_transfer->gpsTransferItems->count();
        })
        ->addColumn('action', function ($gps_transfer)
        {
            $b_url = \URL::to('/');
            if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
            {
                return "
                <a href=".$b_url."/gps-transfer-root-distributor-dealer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=cancelDealerGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                </button>";
            }
            else if($gps_transfer->deleted_at != null){
                return "
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#FF0000';>Cancelled</b>";
            }
            else{
                return "
                <a href=".$b_url."/gps-transfer-root-distributor-dealer/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#008000';>Transferred</b>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create dealer gps transfer
    public function createDealerGpsTransfer(Request $request)
    {
        $user = \Auth::user();
        $dealer = $user->dealer;
        $dealer_id = $user->dealer->id;
        $devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id')
                        ->with('gps')
                        ->where('dealer_id',$dealer_id)
                        ->where('subdealer_id',null)
                        ->get();
        $entities = $dealer->subDealers()->with('user')->get();

        $entities = $entities->where('user.deleted_at',null);

        return view('Warehouse::dealer-gps-transfer', ['devices' => $devices, 'entities' => $entities,
            'logged_distributer_id' => $dealer_id]);
    }

    //get address and mobile details based on subdealer selection
    public function getSubDealerDetailsFromDealer(Request $request)
    {
        $sub_dealer_user_id=$request->sub_dealer_user_id;
        $sub_dealer_user_detalis=User::find($sub_dealer_user_id);
        $sub_dealer_details = SubDealer::select('id', 'name', 'address','user_id')
                        ->where('user_id',$sub_dealer_user_id)
                        ->first();
        $sub_dealer_name=$sub_dealer_details->name;
        $sub_dealer_address=$sub_dealer_details->address;
        $sub_dealer_mobile=$sub_dealer_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'sub_dealer_name' => $sub_dealer_name,
              'sub_dealer_address' => $sub_dealer_address,
              'sub_dealer_mobile' => $sub_dealer_mobile
        ));
    }

    // proceed gps transfer for confirmation
    public function proceedDealerGpsTransfer(Request $request)
    {
        if($request->gps_id[0]==null){
            $rules = $this->gpsDealerTransferRule();
        }else{
            $rules = $this->gpsDealerTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
        $sub_dealer_user_id=$request->sub_dealer_user_id;
        $sub_dealer_name=$request->sub_dealer_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $gps_array_list = $request->gps_id;
        $gps_arrays=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_arrays as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();

        foreach ($devices as $device) {
            $gps_array[]=$device->id;
        }

        // return view('Warehouse::dealer-gps-transfer_proceed', ['sub_dealer_user_id' => $sub_dealer_user_id,'sub_dealer_name' => $sub_dealer_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);

        $dealer_id=\Auth::user()->dealer->id;
        $from_user_id = \Auth::user()->id;
        $to_user_id = $sub_dealer_user_id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')->where('dealer_id',$dealer_id)->whereNotNull('subdealer_id')->whereIn('gps_id',$gps_array)->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-dealer.create'));
        }else{
            $uniqid=uniqid();
            $order_number=$uniqid.date("Y-m-d h:i:s");
            if($gps_array){
                $gps_transfer = GpsTransfer::create([
                  "from_user_id" => $from_user_id,
                  "to_user_id" => $to_user_id,
                  "order_number" => $order_number,
                  "scanned_employee_code" => $scanned_employee_code,
                  "invoice_number" => $invoice_number,
                  "dispatched_on" => date('Y-m-d H:i:s')
                ]);
                $last_id_in_gps_transfer=$gps_transfer->id;
            }
            if($last_id_in_gps_transfer){
                foreach ($gps_array as $gps_id) {
                    $gps_transfer_item = GpsTransferItems::create([
                      "gps_id" => $gps_id,
                      "gps_transfer_id" => $last_id_in_gps_transfer
                    ]);
                    if($gps_transfer_item){
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->subdealer_id =0;
                        $gps->device_to_transfer = 0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'GPS Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-root-distributor-dealer.label',$encrypted_gps_transfer_id));
        }
    }

    // save dealer gps transfer/transfer gps from dealer to sub dealer
    // public function proceedConfirmDealerGpsTransfer(Request $request)
    // {
    //     $dealer_id=\Auth::user()->dealer->id;
    //     $from_user_id = \Auth::user()->id;
    //     $gps_array = $request->gps_id;
    //     $to_user_id = $request->sub_dealer_user_id;
    //     $scanned_employee_code=$request->scanned_employee_code;
    //     $invoice_number=$request->invoice_number;
    //     $transferred_devices=[];
    //     $transfer_inprogress_devices = GpsStock::select('gps_id')->where('dealer_id',$dealer_id)->whereNotNull('subdealer_id')->whereIn('gps_id',$gps_array)->get();
    //     foreach ($transfer_inprogress_devices as $devices) {
    //         $transferred_devices[]=$devices->gps_id;
    //     }
    //     if($transferred_devices){
    //         $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-dealer.create'));
    //     }else{
    //         $uniqid=uniqid();
    //         $order_number=$uniqid.date("Y-m-d h:i:s");
    //         if($gps_array){
    //             $gps_transfer = GpsTransfer::create([
    //               "from_user_id" => $from_user_id,
    //               "to_user_id" => $to_user_id,
    //               "order_number" => $order_number,
    //               "scanned_employee_code" => $scanned_employee_code,
    //               "invoice_number" => $invoice_number,
    //               "dispatched_on" => date('Y-m-d H:i:s')
    //             ]);
    //             $last_id_in_gps_transfer=$gps_transfer->id;
    //         }
    //         if($last_id_in_gps_transfer){
    //             foreach ($gps_array as $gps_id) {
    //                 $gps_transfer_item = GpsTransferItems::create([
    //                   "gps_id" => $gps_id,
    //                   "gps_transfer_id" => $last_id_in_gps_transfer
    //                 ]);
    //                 if($gps_transfer_item){
    //                     //update gps stock table
    //                     $gps = GpsStock::where('gps_id',$gps_id)->first();
    //                     $gps->subdealer_id =0;
    //                     $gps->save();
    //                 }
    //             }
    //         }
    //         $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
    //         $request->session()->flash('message', 'GPS Transfer successfully completed!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-root-distributor-dealer.label',$encrypted_gps_transfer_id));
    //     }
    // }

    // gps transfer list - sub dealer to trader
    public function getSubDealerToTraderTransferredList() 
    {
        return view('Warehouse::gps-transfer-subdealer-to trader-list');
    }

    //gps transfer list data - sub dealer to trader
    public function getSubDealerToTraderTransferredListData(Request $request) 
    {
        $user_id            = \Auth::user()->id;
        $subdealer_id       = \Auth::user()->subdealer->id;
        $traders            = Trader::select('user_id')->where('sub_dealer_id',$subdealer_id)->withTrashed()->get();
        $trader_user_ids    = [];
        $from_date=$request['from_date'];
        $to_date=$request['to_date'];
        foreach($traders as $trader)
        {
            array_push($trader_user_ids, $trader->user_id);
        }

        $gps_transfer = GpsTransfer::select(
            'id', 
            'from_user_id', 
            'to_user_id',
            'dispatched_on',
            'accepted_on',
            'deleted_at'
            // \DB::raw('count(id) as count') 
        )
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gpsTransferItems')
        ->where('from_user_id',$user_id)
        ->whereIn('to_user_id',$trader_user_ids)
        ->orderBy('id','DESC')
        ->withTrashed();
        if($from_date){
            $search_from_date=date("Y-m-d", strtotime($from_date));
            $search_to_date=date("Y-m-d", strtotime($to_date));
            $gps_transfer = $gps_transfer->whereDate('dispatched_on', '>=', $search_from_date)->whereDate('dispatched_on', '<=', $search_to_date);
        }
        $gps_transfer = $gps_transfer->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->addColumn('count', function ($gps_transfer) 
        {
            return $gps_transfer->gpsTransferItems->count();
        })
        ->addColumn('action', function ($gps_transfer) 
        {
            $b_url = \URL::to('/');
            if($gps_transfer->accepted_on == null && $gps_transfer->deleted_at == null)
            {
                return "
                <a href=".$b_url."/gps-transfer-root-sub-dealer-trader/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <button onclick=cancelSubDealerToTraderGpsTransfer(".$gps_transfer->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Cancel
                </button>";
            }
            else if($gps_transfer->deleted_at != null){
                return "
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#FF0000';>Cancelled</b>";
            }
            else{
                return "
                <a href=".$b_url."/gps-transfer-root-sub-dealer-trader/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
                <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                <b style='color:#008000';>Transferred</b>";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create dealer to sub dealer (sub dealer to trader) gps transfer
    public function createSubDealerToTraderGpsTransfer(Request $request) 
    {
        $user = \Auth::user();
        $sub_dealer=$user->subdealer;
        $subdealer_id=$sub_dealer->id;
        $devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id','trader_id','client_id')
                        ->with('gps')
                        ->where('subdealer_id',$subdealer_id)
                        ->where('client_id',null)
                        ->where('trader_id',null)
                        ->get();
        $entities = $sub_dealer->traders()->with('user')->get();
        
        $entities = $entities->where('user.deleted_at',null);

        return view('Warehouse::sub-dealer-to-trader-gps-transfer', ['devices' => $devices, 'entities' => $entities,'subdealer_id'=>$subdealer_id]);
    }

    //get address and mobile details based on (trader) selection
    public function getTraderDetailsFromSubDealer(Request $request)
    {
        $trader_user_id=$request->trader_user_id;
        $trader_user_detalis=User::find($trader_user_id);
        $trader_details = Trader::select('id', 'name', 'address','user_id')
                        ->where('user_id',$trader_user_id)
                        ->first();
        $trader_name=$trader_details->name;
        $trader_address=$trader_details->address;
        $trader_mobile=$trader_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'trader_name' => $trader_name,
              'trader_address' => $trader_address,
              'trader_mobile' => $trader_mobile
        )); 
    }

    // proceed gps transfer for confirmation
    public function proceedSubDealerToTraderGpsTransfer(Request $request) 
    {
        if($request->gps_id[0]==null){
            $rules = $this->gpsSubDealerToTraderTransferRule();
        }else{
            $rules = $this->gpsSubDealerToTraderTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
        $trader_user_id=$request->trader_user_id;
        $trader_id = Trader::where('user_id',$trader_user_id)->first();
        $trader_name=$request->trader_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $gps_array_list = $request->gps_id;
        $gps_arrays=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_arrays as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();

        foreach ($devices as $device) {
            $gps_array[]=$device->id;
        }

        // return view('Warehouse::sub-dealer-to-trader-gps-transfer_proceed', ['trader_user_id' => $trader_user_id,'trader_name' => $trader_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);


        $subdealer_id=\Auth::user()->subdealer->id;
        $from_user_id = \Auth::user()->id;
        $to_user_id = $request->trader_user_id;
        $trader_id = $trader_id->id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')
                                        ->where('subdealer_id',$subdealer_id)
                                        ->whereIn('gps_id',$gps_array)
                                        ->where(function ($query) {
                                            $query->whereNotNull('trader_id')
                                            ->orWhereNotNull('client_id');
                                            })
                                        ->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-sub-dealer-trader.create'));
        }else{
            $uniqid=uniqid();
            $order_number=$uniqid.date("Y-m-d h:i:s");
            if($gps_array){
                $gps_transfer = GpsTransfer::create([
                  "from_user_id" => $from_user_id, 
                  "to_user_id" => $to_user_id,
                  "order_number" => $order_number,
                  "scanned_employee_code" => $scanned_employee_code,
                  "invoice_number" => $invoice_number,
                  "dispatched_on" => date('Y-m-d H:i:s')
                ]);
                $last_id_in_gps_transfer=$gps_transfer->id;
            }
            if($last_id_in_gps_transfer){
                foreach ($gps_array as $gps_id) {
                    $gps_transfer_item = GpsTransferItems::create([
                      "gps_id" => $gps_id, 
                      "gps_transfer_id" => $last_id_in_gps_transfer
                    ]);
                    if($gps_transfer_item){
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->trader_id =0;
                        $gps->device_to_transfer =0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'GPS Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-root-sub-dealer-trader.label',$encrypted_gps_transfer_id));
        }
    }

    // save sub dealer gps transfer/transfer gps from dealer(sub dealer) to sub dealer(trader)
    // public function proceedConfirmSubDealerToTraderGpsTransfer(Request $request) 
    // {
    //     $subdealer_id=\Auth::user()->subdealer->id;
    //     $from_user_id = \Auth::user()->id;
    //     $gps_array = $request->gps_id;
    //     $to_user_id = $request->trader_user_id;
    //     $trader_id = $request->trader_id;
    //     $scanned_employee_code=$request->scanned_employee_code;
    //     $invoice_number=$request->invoice_number;
    //     $transferred_devices=[];
    //     $transfer_inprogress_devices = GpsStock::select('gps_id')
    //                                     ->where('subdealer_id',$subdealer_id)
    //                                     ->whereIn('gps_id',$gps_array)
    //                                     ->where(function ($query) {
    //                                         $query->whereNotNull('trader_id')
    //                                         ->orWhereNotNull('client_id');
    //                                         })
    //                                     ->get();
    //     foreach ($transfer_inprogress_devices as $devices) {
    //         $transferred_devices[]=$devices->gps_id;
    //     }
    //     if($transferred_devices){
    //         $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-sub-dealer-trader.create'));
    //     }else{
    //         $uniqid=uniqid();
    //         $order_number=$uniqid.date("Y-m-d h:i:s");
    //         if($gps_array){
    //             $gps_transfer = GpsTransfer::create([
    //               "from_user_id" => $from_user_id, 
    //               "to_user_id" => $to_user_id,
    //               "order_number" => $order_number,
    //               "scanned_employee_code" => $scanned_employee_code,
    //               "invoice_number" => $invoice_number,
    //               "dispatched_on" => date('Y-m-d H:i:s')
    //             ]);
    //             $last_id_in_gps_transfer=$gps_transfer->id;
    //         }
    //         if($last_id_in_gps_transfer){
    //             foreach ($gps_array as $gps_id) {
    //                 $gps_transfer_item = GpsTransferItems::create([
    //                   "gps_id" => $gps_id, 
    //                   "gps_transfer_id" => $last_id_in_gps_transfer
    //                 ]);
    //                 if($gps_transfer_item){
    //                     //update gps stock table
    //                     $gps = GpsStock::where('gps_id',$gps_id)->first();
    //                     $gps->trader_id =0;
    //                     $gps->save();
    //                 }
    //             }
    //         }
    //         $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
    //         $request->session()->flash('message', 'GPS Transfer successfully completed!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-root-sub-dealer-trader.label',$encrypted_gps_transfer_id));
    //     }
    // }

    // gps transfer list - dealer
    public function getSubDealerList()
    {
        return view('Warehouse::gps-transfer-subdealer-list');
    }

    //gps transfer list data - dealer
    public function getSubDealerListData(Request $request)
    {
        $user_id            = \Auth::user()->id;
        $subdealer_id       = \Auth::user()->subdealer->id;
        $clients            = Client::select('user_id')->where('sub_dealer_id',$subdealer_id)->withTrashed()->get();
        $client_user_ids    = [];
        $from_date=$request['from_date'];
        $to_date=$request['to_date'];

        foreach($clients as $client)
        {
            array_push($client_user_ids, $client->user_id);
        }

        $gps_transfer = GpsTransfer::select(
            'id',
            'from_user_id',
            'to_user_id',
            'dispatched_on',
            'accepted_on',
            'deleted_at'
            // \DB::raw('count(id) as count')
        )
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gpsTransferItems')
        ->where('from_user_id',$user_id)
        ->whereIn('to_user_id',$client_user_ids)
        ->orderBy('id','DESC')
        ->withTrashed();
        if($from_date){
            $search_from_date=date("Y-m-d", strtotime($from_date));
            $search_to_date=date("Y-m-d", strtotime($to_date));
            $gps_transfer = $gps_transfer->whereDate('dispatched_on', '>=', $search_from_date)->whereDate('dispatched_on', '<=', $search_to_date);
        }
        $gps_transfer = $gps_transfer->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->addColumn('count', function ($gps_transfer)
        {
            return $gps_transfer->gpsTransferItems->count();
        })
        ->addColumn('action', function ($gps_transfer)
        {
            $b_url = \URL::to('/');
            return "
            <a href=".$b_url."/gps-transfer-root-dealer-client/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
            <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <b style='color:#008000';>Transferred</b>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // create sub dealer gps transfer
    public function createSubDealerGpsTransfer(Request $request)
    {
        $user = \Auth::user();
        $sub_dealer=$user->subdealer;
        $subdealer_id=$sub_dealer->id;
        $devices = GpsStock::select('id', 'gps_id','dealer_id','subdealer_id','trader_id','client_id')
                        ->with('gps')
                        ->where('subdealer_id',$subdealer_id)
                        ->where('client_id',null)
                        ->where('trader_id',null)
                        ->get();
        $entities = $sub_dealer->clients()->with('user')->get();

        $entities = $entities->where('user.deleted_at',null);

        return view('Warehouse::sub-dealer-gps-transfer', ['devices' => $devices, 'entities' => $entities,'subdealer_id' => $subdealer_id]);
    }

    //get address and mobile details based on client selection
    public function getClientDetailsFromSubDealer(Request $request)
    {
        $client_user_id=$request->client_user_id;
        $client_user_detalis=User::find($client_user_id);
        $client_details = Client::select('id', 'name', 'address','user_id')
                        ->where('user_id',$client_user_id)
                        ->first();
        $client_name=$client_details->name;
        $client_address=$client_details->address;
        $client_mobile=$client_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'client_name' => $client_name,
              'client_address' => $client_address,
              'client_mobile' => $client_mobile
        ));
    }

    // proceed gps transfer for confirmation
    public function proceedSubDealerGpsTransfer(Request $request)
    {
        if($request->gps_id[0]==null){
            $rules = $this->gpsSubDealerTransferRule();
        }else{
            $rules = $this->gpsSubDealerTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
        $client_user_id=$request->client_user_id;
        $client = Client::where('user_id',$client_user_id)->first();
        $client_name=$request->client_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $gps_array_list = $request->gps_id;
        $gps_arrays=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_arrays as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();

        foreach ($devices as $device) {
            $gps_array[]=$device->id;
        }


        // return view('Warehouse::sub-dealer-gps-transfer_proceed', ['client_user_id' => $client_user_id,'client_id' => $client_id,'client_name' => $client_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);


        $subdealer_id=\Auth::user()->subdealer->id;
        $from_user_id = \Auth::user()->id;
        $to_user_id = $client_user_id;
        $client_id = $client->id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        $transferred_devices=[];
        $transfer_inprogress_devices = GpsStock::select('gps_id')
                                        ->where('subdealer_id',$subdealer_id)
                                        ->whereIn('gps_id',$gps_array)
                                        ->where(function ($query) {
                                            $query->whereNotNull('trader_id')
                                            ->orWhereNotNull('client_id');
                                            })
                                        ->get();
        foreach ($transfer_inprogress_devices as $devices) {
            $transferred_devices[]=$devices->gps_id;
        }
        if($transferred_devices){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-sub-dealer.create'));
        }else{
            $uniqid=uniqid();
            $order_number=$uniqid.date("Y-m-d h:i:s");
            if($gps_array){
                $gps_transfer = GpsTransfer::create([
                  "from_user_id" => $from_user_id,
                  "to_user_id" => $to_user_id,
                  "order_number" => $order_number,
                  "scanned_employee_code" => $scanned_employee_code,
                  "invoice_number" => $invoice_number,
                  "dispatched_on" => date('Y-m-d H:i:s'),
                  "accepted_on" => date('Y-m-d H:i:s')
                ]);
                $last_id_in_gps_transfer=$gps_transfer->id;
            }
            if($last_id_in_gps_transfer){
                foreach ($gps_array as $gps_id) {
                    $gps_transfer_item = GpsTransferItems::create([
                      "gps_id" => $gps_id,
                      "gps_transfer_id" => $last_id_in_gps_transfer
                    ]);
                    if($gps_transfer_item){
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->client_id =$client_id;
                        $gps->device_to_transfer =0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'GPS Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-root-dealer-client.label',$encrypted_gps_transfer_id));
        }
    }

    // save dealer gps transfer/transfer gps from sub dealer to client
    // public function proceedConfirmSubDealerGpsTransfer(Request $request)
    // {
    //     $subdealer_id=\Auth::user()->subdealer->id;
    //     $from_user_id = \Auth::user()->id;
    //     $gps_array = $request->gps_id;
    //     $to_user_id = $request->client_user_id;
    //     $client_id = $request->client_id;
    //     $scanned_employee_code=$request->scanned_employee_code;
    //     $invoice_number=$request->invoice_number;
    //     $transferred_devices=[];
    //     $transfer_inprogress_devices = GpsStock::select('gps_id')
    //                                     ->where('subdealer_id',$subdealer_id)
    //                                     ->whereIn('gps_id',$gps_array)
    //                                     ->where(function ($query) {
    //                                         $query->whereNotNull('trader_id')
    //                                         ->orWhereNotNull('client_id');
    //                                         })
    //                                     ->get();
    //     foreach ($transfer_inprogress_devices as $devices) {
    //         $transferred_devices[]=$devices->gps_id;
    //     }
    //     if($transferred_devices){
    //         $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-sub-dealer.create'));
    //     }else{
    //         $uniqid=uniqid();
    //         $order_number=$uniqid.date("Y-m-d h:i:s");
    //         if($gps_array){
    //             $gps_transfer = GpsTransfer::create([
    //               "from_user_id" => $from_user_id,
    //               "to_user_id" => $to_user_id,
    //               "order_number" => $order_number,
    //               "scanned_employee_code" => $scanned_employee_code,
    //               "invoice_number" => $invoice_number,
    //               "dispatched_on" => date('Y-m-d H:i:s'),
    //               "accepted_on" => date('Y-m-d H:i:s')
    //             ]);
    //             $last_id_in_gps_transfer=$gps_transfer->id;
    //         }
    //         if($last_id_in_gps_transfer){
    //             foreach ($gps_array as $gps_id) {
    //                 $gps_transfer_item = GpsTransferItems::create([
    //                   "gps_id" => $gps_id,
    //                   "gps_transfer_id" => $last_id_in_gps_transfer
    //                 ]);
    //                 if($gps_transfer_item){
    //                     //update gps stock table
    //                     $gps = GpsStock::where('gps_id',$gps_id)->first();
    //                     $gps->client_id =$client_id;
    //                     $gps->save();
    //                 }
    //             }
    //         }
    //         $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
    //         $request->session()->flash('message', 'GPS Transfer successfully completed!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-root-dealer-client.label',$encrypted_gps_transfer_id));
    //     }
    // }

    // gps transfer list - dealer
    public function getTraderToClientTransferredList()
    {
        return view('Warehouse::gps-transfer-trader-to-end-user-list');
    }

    //gps transfer list data - dealer
    public function getTraderToClientTransferredListData(Request $request)
    {
        $user_id            = \Auth::user()->id; 
        $from_date=$request['from_date'];
        $to_date=$request['to_date'];
        $gps_transfer = GpsTransfer::select(
            'id',
            'from_user_id',
            'to_user_id',
            'dispatched_on',
            'accepted_on',
            'deleted_at'
            // \DB::raw('count(id) as count')
        )
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gpsTransferItems')
        ->where('from_user_id',$user_id)
        ->orderBy('id','DESC')
        ->withTrashed();
        if($from_date){
            $search_from_date=date("Y-m-d", strtotime($from_date));
            $search_to_date=date("Y-m-d", strtotime($to_date));
            $gps_transfer = $gps_transfer->whereDate('dispatched_on', '>=', $search_from_date)->whereDate('dispatched_on', '<=', $search_to_date);
        }
        $gps_transfer = $gps_transfer->get();
        return DataTables::of($gps_transfer)
        ->addIndexColumn()
        ->addColumn('count', function ($gps_transfer)
        {
            return $gps_transfer->gpsTransferItems->count();
        })
        ->addColumn('action', function ($gps_transfer)
        {
            $b_url = \URL::to('/');
            return "
            <a href=".$b_url."/gps-transfer-root-trader-end-user/".Crypt::encrypt($gps_transfer->id)."/label class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> Box Label </a>
            <a href=".$b_url."/gps-transfer/".Crypt::encrypt($gps_transfer->id)."/view class='btn btn-xs btn-success'><i class='glyphicon glyphicon-eye-open'></i> View </a>
            <b style='color:#008000';>Transferred</b>";
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    // gps transfer from trader to client
    public function createTraderToClientGpsTransfer(Request $request)
    {
        $user       =   \Auth::user();
        $trader     =   $user->trader;
        $trader_id  =   $trader->id;
        $devices    =   GpsStock::select('id', 'gps_id','dealer_id','subdealer_id','trader_id','client_id')
                        ->with('gps')
                        ->where('trader_id',$trader_id)
                        ->where('client_id',null)
                        ->get();
        $entities   =   $trader->clients()->with('user')->get();
        $entities   =   $entities->where('user.deleted_at',null);
        return view('Warehouse::trader-to-end-user-gps-transfer', ['devices' => $devices, 'entities' => $entities,'trader_id' => $trader_id]);
    }

    //get address and mobile details based on client selection in trader transfer page
    public function getClientDetailsInTrader(Request $request)
    {
        $client_user_id=$request->client_user_id;
        $client_user_detalis=User::find($client_user_id);
        $client_details = Client::select('id', 'name', 'address','user_id')
                        ->where('user_id',$client_user_id)
                        ->first();
        $client_name=$client_details->name;
        $client_address=$client_details->address;
        $client_mobile=$client_user_detalis->mobile;
        return response()->json(array(
              'response' => 'success',
              'client_name' => $client_name,
              'client_address' => $client_address,
              'client_mobile' => $client_mobile
        ));
    }

    // proceed gps transfer from trader to client for confirmation
    public function proceedTraderToClientGpsTransfer(Request $request)
    {
        if($request->gps_id[0]==null){
            $rules = $this->gpsTraderToClientTransferRule();
        }else{
            $rules = $this->gpsTraderToClientTransferNullRule();
        }
        $this->validate($request, $rules,['gps_id.min' => 'Please scan at least one QR code']);
        $client_user_id=$request->client_user_id;
        $client = Client::where('user_id',$client_user_id)->first();
        $client_name=$request->client_name;
        $address=$request->address;
        $mobile=$request->mobile;
        $gps_array_list = $request->gps_id;
        $gps_arrays=explode(",",$gps_array_list[0]);
        $gps_list=[];
        foreach ($gps_arrays as $gps_id) {
            $gps_list[]=$gps_id;
        }
        $devices = Gps::select('id', 'serial_no')
                        ->whereIn('id',$gps_list)
                        ->get();

        foreach ($devices as $device) {
            $gps_array[]=$device->id;
        }

        // return view('Warehouse::trader-to-end-user-gps-transfer_proceed', ['client_user_id' => $client_user_id,'client_id' => $client_id,'client_name' => $client_name, 'address' => $address,'mobile' => $mobile, 'scanned_employee_code' => $scanned_employee_code, 'invoice_number' => $invoice_number,'devices' => $devices]);

        $trader_id=\Auth::user()->trader->id;
        $from_user_id = \Auth::user()->id;
        $to_user_id = $client_user_id;
        $client_id = $client->id;
        $scanned_employee_code=$request->scanned_employee_code;
        $invoice_number=$request->invoice_number;
        //to check the device is already transferred or not
        $transferred_devices = GpsStock::select('gps_id')
                                        ->where('trader_id',$trader_id)
                                        ->whereIn('gps_id',$gps_array)
                                        ->whereNotNull('client_id')
                                        ->count();
        if($transferred_devices >= 1){
            $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-trader-end-user.create'));
        }else{
            $uniqid=uniqid();
            $order_number=$uniqid.date("Y-m-d h:i:s");
            if($gps_array){
                $gps_transfer = GpsTransfer::create([
                  "from_user_id" => $from_user_id,
                  "to_user_id" => $to_user_id,
                  "order_number" => $order_number,
                  "scanned_employee_code" => $scanned_employee_code,
                  "invoice_number" => $invoice_number,
                  "dispatched_on" => date('Y-m-d H:i:s'),
                  "accepted_on" => date('Y-m-d H:i:s')
                ]);
                $last_id_in_gps_transfer=$gps_transfer->id;
            }
            if($last_id_in_gps_transfer){
                foreach ($gps_array as $gps_id) {
                    $gps_transfer_item = GpsTransferItems::create([
                      "gps_id" => $gps_id,
                      "gps_transfer_id" => $last_id_in_gps_transfer
                    ]);
                    if($gps_transfer_item){
                        //update gps stock table
                        $gps = GpsStock::where('gps_id',$gps_id)->first();
                        $gps->client_id =$client_id;
                        $gps->device_to_transfer =0;
                        $gps->save();
                    }
                }
            }
            $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
            $request->session()->flash('message', 'GPS Transfer successfully completed!');
            $request->session()->flash('alert-class', 'alert-success');
            return redirect(route('gps-transfer-root-trader-end-user.label',$encrypted_gps_transfer_id));
        }
    }

    // save trader gps transfer/transfer gps from trader to client
    // public function proceedConfirmTraderToClientGpsTransfer(Request $request)
    // {
    //     $trader_id=\Auth::user()->trader->id;
    //     $from_user_id = \Auth::user()->id;
    //     $gps_array = $request->gps_id;
    //     $to_user_id = $request->client_user_id;
    //     $client_id = $request->client_id;
    //     $scanned_employee_code=$request->scanned_employee_code;
    //     $invoice_number=$request->invoice_number;
    //     //to check the device is already transferred or not
    //     $transferred_devices = GpsStock::select('gps_id')
    //                                     ->where('trader_id',$trader_id)
    //                                     ->whereIn('gps_id',$gps_array)
    //                                     ->whereNotNull('client_id')
    //                                     ->count();
    //     if($transferred_devices >= 1){
    //         $request->session()->flash('message', 'Sorry!! This transaction is cancelled, GPS list contains already transferred devices');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-trader-end-user.create'));
    //     }else{
    //         $uniqid=uniqid();
    //         $order_number=$uniqid.date("Y-m-d h:i:s");
    //         if($gps_array){
    //             $gps_transfer = GpsTransfer::create([
    //               "from_user_id" => $from_user_id,
    //               "to_user_id" => $to_user_id,
    //               "order_number" => $order_number,
    //               "scanned_employee_code" => $scanned_employee_code,
    //               "invoice_number" => $invoice_number,
    //               "dispatched_on" => date('Y-m-d H:i:s'),
    //               "accepted_on" => date('Y-m-d H:i:s')
    //             ]);
    //             $last_id_in_gps_transfer=$gps_transfer->id;
    //         }
    //         if($last_id_in_gps_transfer){
    //             foreach ($gps_array as $gps_id) {
    //                 $gps_transfer_item = GpsTransferItems::create([
    //                   "gps_id" => $gps_id,
    //                   "gps_transfer_id" => $last_id_in_gps_transfer
    //                 ]);
    //                 if($gps_transfer_item){
    //                     //update gps stock table
    //                     $gps = GpsStock::where('gps_id',$gps_id)->first();
    //                     $gps->client_id =$client_id;
    //                     $gps->save();
    //                 }
    //             }
    //         }
    //         $encrypted_gps_transfer_id = encrypt($gps_transfer->id);
    //         $request->session()->flash('message', 'GPS Transfer successfully completed!');
    //         $request->session()->flash('alert-class', 'alert-success');
    //         return redirect(route('gps-transfer-root-trader-end-user.label',$encrypted_gps_transfer_id));
    //     }
    // }

    //view gps transfer list
    public function viewGpsTransfer(Request $request)
    {
        $search_key                 = ( isset($request->search) ) ? $request->search : '';
        $transferred_gps_device_ids = [];
        $transferred_gps_details    = [];
        $gps_transfer_id            = ( $request->ajax() ) ? $request->gps_transfer_id : Crypt::decrypt($request->id);   
        $transferred_gps_devices    =   (new GpsTransferItems())->getTransferredGpsDevices($gps_transfer_id);
        if( $transferred_gps_devices != null )
        {
            foreach($transferred_gps_devices as $each_transfer)
            {
                array_push($transferred_gps_device_ids, $each_transfer->gps_id);
            }
            $transferred_gps_details = (new Gps())->getTransferredGpsDetails($transferred_gps_device_ids, $search_key);
        }
        // Response
        if($request->ajax())
        {
            return ($transferred_gps_devices != null) ? Response([ 'links' => $transferred_gps_details->appends(['sort' => 'votes'])]) : Response([ 'links' => null]);
        }
        else
        {
            return ($transferred_gps_devices != null) ? view('Warehouse::gps-list-view',['devices' => $transferred_gps_details, 'gps_transfer_id' => $gps_transfer_id]) : view('Warehouse::404');
        }
    }

    //accept transferred gps in dealer
    public function AcceptGpsDealerTransfer(Request $request)
    {
        $dealer_id = \Auth::user()->dealer->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $gps_transfer->accepted_on =date('Y-m-d H:i:s');
        $accept_gps=$gps_transfer->save();
        if($accept_gps){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Gps::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->dealer_id =$dealer_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'GPS accepted successfully'
        ]);
    }

    //accept transferred gps in sub dealer
    public function AcceptGpsSubDealerTransfer(Request $request)
    {
        $subdealer_id = \Auth::user()->subdealer->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $gps_transfer->accepted_on =date('Y-m-d H:i:s');
        $accept_gps=$gps_transfer->save();
        if($accept_gps){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->subdealer_id =$subdealer_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'GPS accepted successfully'
        ]);
    }

    //accept transferred gps from sub deater(dealer) to trader(sub dealer)
    public function AcceptGpsSubDealerToTraderTransfer(Request $request)
    {
        $trader_id = \Auth::user()->trader->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $gps_transfer->accepted_on =date('Y-m-d H:i:s');
        $accept_gps=$gps_transfer->save();
        if($accept_gps){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                
                $gps->trader_id =$trader_id;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'GPS accepted successfully'
        ]);
    }

    //cancel root gps transfer
    public function cancelRootGpsTransfer(Request $request){
        $user_id = \Auth::user()->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $cancel_transfer=$gps_transfer->delete();
        if($cancel_transfer){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->dealer_id =null;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'GPS transfer cancelled successfully'
        ]);
    }

    //cancel dealer gps transfer
    public function cancelDealerGpsTransfer(Request $request){
        $user_id = \Auth::user()->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $cancel_transfer=$gps_transfer->delete();
        if($cancel_transfer){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->subdealer_id =null;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'GPS transfer cancelled successfully'
        ]);
    }

    //cancel sub dealer to trader gps transfer
    public function cancelSubDealerToTraderGpsTransfer(Request $request){
        $user_id = \Auth::user()->id;
        $gps_transfer = GpsTransfer::find($request->id);
        if($gps_transfer == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Transferred gps does not exist'
            ]);
        }
        $cancel_transfer=$gps_transfer->delete();
        if($cancel_transfer){
            $gps_items = GpsTransferItems::select( 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer->id)
                        ->get();
            if($gps_items == null){
               return view('Warehouse::404');
            }
            $devices=array();
            foreach($gps_items as $gps_item){
                $single_gps_id= $gps_item->gps_id;
                //update gps table
                $gps = GpsStock::where('gps_id',$single_gps_id)->first();
                $gps->trader_id =null;
                $gps->save();
            }
        }
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'GPS transfer cancelled successfully'
        ]);
    }

    public function gpsTransferLabelRootManufacturerToDistributor(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_transfer = GpsTransfer::find($decrypted_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
        $role_details = Dealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        if($gps_transfer == null){
           return view('Warehouse::404');
        }
       return view('Warehouse::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
    }

    public function gpsTransferLabelRootDistributorToDealer(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_transfer = GpsTransfer::find($decrypted_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
        $role_details = SubDealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        if($gps_transfer == null){
           return view('Warehouse::404');
        }
       return view('Warehouse::gps-transfer-label-root-distributor-dealer',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
    }

    public function gpsTransferLabelRootDealerToClient(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_transfer = GpsTransfer::find($decrypted_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
                        // dd($gps_transfer);
        $role_details = Client::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        if($gps_transfer == null){
           return view('Warehouse::404');
        }
       return view('Warehouse::gps-transfer-label-root-dealer-client',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
    }

    public function gpsTransferLabelRootSubDealerToTrader(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_transfer = GpsTransfer::find($decrypted_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
                        // dd($gps_transfer);
        $role_details = Trader::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        if($gps_transfer == null){
           return view('Warehouse::404');
        }
       return view('Warehouse::gps-transfer-label-root-sub-dealer-trader',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
    }

    public function gpsTransferLabelRootTraderToClient(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_transfer = GpsTransfer::find($decrypted_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
                        // dd($gps_transfer);
        $role_details = Client::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        if($gps_transfer == null){
           return view('Warehouse::404');
        }
       return view('Warehouse::gps-transfer-label-root-trader-end-user',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
    }

    //label for transferred gps
    public function gpsTransferLabel(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $decrypted_id = Crypt::decrypt($request->id);
        $gps_transfer = GpsTransfer::find($decrypted_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$decrypted_id)
                        ->get();
        $role_details = Dealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        if($gps_transfer == null){
           return view('Warehouse::404');
        }
       return view('Warehouse::gps-transfer-label',['gps_transfer' => $gps_transfer,'gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details]);
    }

    public function exportGpsTransferLabelRootDistributorToDealer(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $gps_transfer_id=$request->id;
        $gps_transfer = GpsTransfer::find($gps_transfer_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer_id)
                        ->get();
        $from_user_details = Dealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->from_user_id)
                            ->first();
        $role_details = SubDealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
         $user_details_data = User::select('id', 'mobile')
        ->where('id',$from_user_details->user_id)
        ->first();
        view()->share('gps_transfer',$gps_transfer);
        $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details,'from_user_details' => $from_user_details,'user_details_data' => $user_details_data]);
        $headers = array(
                  'Content-Type'=> 'application/pdf'
                );
        return $pdf->download('GPSTransferLabel.pdf',$headers);
    }

    public function exportGpsTransferLabelRootDealerToClient(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $gps_transfer_id=$request->id;
        $gps_transfer = GpsTransfer::find($gps_transfer_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer_id)
                        ->get();
        $from_user_details = SubDealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->from_user_id)
                            ->first();
        $role_details = Client::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
         $user_details_data = User::select('id', 'mobile')
        ->where('id',$from_user_details->user_id)
        ->first();
        view()->share('gps_transfer',$gps_transfer);
        $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details,'from_user_details' => $from_user_details,'user_details_data' => $user_details_data]);
        $headers = array(
                  'Content-Type'=> 'application/pdf'
                );
        return $pdf->download('GPSTransferLabel.pdf',$headers);
    }

    public function exportGpsTransferLabelRootSubDealerToTrader(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $gps_transfer_id=$request->id;
        $gps_transfer = GpsTransfer::find($gps_transfer_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer_id)
                        ->get();
        $from_user_details = SubDealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->from_user_id)
                            ->first();
        $role_details = Trader::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
         $user_details_data = User::select('id', 'mobile')
        ->where('id',$from_user_details->user_id)
        ->first();
        view()->share('gps_transfer',$gps_transfer);
        $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details,'from_user_details' => $from_user_details,'user_details_data' => $user_details_data]);
        $headers = array(
                  'Content-Type'=> 'application/pdf'
                );
        return $pdf->download('GPSTransferLabel.pdf',$headers);
    }

    public function exportGpsTransferLabelRootTraderToClient(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $gps_transfer_id=$request->id;
        $gps_transfer = GpsTransfer::find($gps_transfer_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer_id)
                        ->get();
        $from_user_details = Trader::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->from_user_id)
                            ->first();
        $role_details = Client::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
         $user_details_data = User::select('id', 'mobile')
        ->where('id',$from_user_details->user_id)
        ->first();
        view()->share('gps_transfer',$gps_transfer);
        $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details,'from_user_details' => $from_user_details,'user_details_data' => $user_details_data]);
        $headers = array(
                  'Content-Type'=> 'application/pdf'
                );
        return $pdf->download('GPSTransferLabel.pdf',$headers);
    }

    public function exportGpsTransferLabel(Request $request)
    {
        \QrCode::size(500)
          ->format('png')
          ->generate(public_path('images/qrcode.png'));
        $gps_transfer_id=$request->id;
        $gps_transfer = GpsTransfer::find($gps_transfer_id);
        $gps_items = GpsTransferItems::select('id', 'gps_transfer_id', 'gps_id')
                        ->where('gps_transfer_id',$gps_transfer_id)
                        ->get();
        $from_user_details = Root::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->from_user_id)
                            ->first();
        $role_details = Dealer::select('id', 'name', 'address','user_id')
                            ->where('user_id',$gps_transfer->to_user_id)
                            ->first();
        $user_details = User::select('id', 'mobile')
                            ->where('id',$role_details->user_id)
                            ->first();
        $user_details_data = User::select('id', 'mobile')
        ->where('id',$from_user_details->user_id)
        ->first();
        view()->share('gps_transfer',$gps_transfer);
        $pdf = PDF::loadView('Exports::gps-transfer-label',['gps_items' => $gps_items,'role_details' => $role_details,'user_details' => $user_details,'from_user_details' => $from_user_details,'user_details_data' => $user_details_data]);
        $headers = array(
                  'Content-Type'=> 'application/pdf'
                );
        return $pdf->download('GPSTransferLabel.pdf',$headers);
    }

    //Device track in root panel

    public function getRootDeviceTrack()
    {
        return view('Warehouse::device-track-root');
    }

    public function getRootDeviceTrackData(Request $request)
    {
        $gps_stock = GpsStock::select('id','gps_id','inserted_by','dealer_id','subdealer_id','trader_id','client_id','deleted_at')
                    ->with('gps')
                    ->with('dealer')
                    ->with('subdealer')
                    ->with('trader')
                    ->with('client')
                    ->with('manufacturer')
                    ->get();
        return DataTables::of($gps_stock)
        ->addIndexColumn()
        ->addColumn('manufacturer',function($gps_stock){
            $manufacturer = $gps_stock->manufacturer['name'];
            return $manufacturer;
        })
        ->addColumn('distributor',function($gps_stock){
            $distributor = $gps_stock->dealer_id;
            if($distributor)
            {
                return $gps_stock->dealer['name'];
               
            }
            else if(isset($distributor))
            {          
                return 'Awaiting Transfer Confirmation';
            }
            else{
                return "--";
            }
           
        })
        ->addColumn('dealer',function($gps_stock){
            $dealer = $gps_stock->subdealer_id;
            if($dealer)
            {
                return $gps_stock->subdealer['name'];
               
            }
            else if(isset($dealer))
            {          
                return 'Awaiting Transfer Confirmation';
            }
            else{
                return "--";
            }
        })
        ->addColumn('sub_dealer',function($gps_stock){
            $sub_dealer = $gps_stock->trader_id;
            if($sub_dealer)
            {
                return $gps_stock->trader['name'];
               
            }
            else if(isset($sub_dealer))
            {          
                return 'Awaiting Transfer Confirmation';
            }
            else{
                return "--";
            }
        })
        ->addColumn('client',function($gps_stock){
            $subdealer = $gps_stock->client_id;
            if($subdealer)
            {
                return $gps_stock->client['name'];
               
            }
            else if(isset($subdealer))
            {          
                return 'Awaiting Transfer Confirmation';
            }
            else{
                return "--";
            }
        })
        ->addColumn('action', function ($gps_stock)
        {
            $b_url = \URL::to('/');
            if($gps_stock->deleted_at == null)
            {
                return "
                <a href=".$b_url."/gps-device-track-root-details/".Crypt::encrypt($gps_stock->gps_id)."/view class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
               
            }
            else{
                return "";
            }
        })
        ->rawColumns(['link', 'action'])
        ->make();
    }

    public function rootDeviceTrackDetails(Request $request)
    {
        $decrypted_gps_id = Crypt::decrypt($request->id);
        $gps_transfer_items = GpsTransferItems::where('gps_id',$decrypted_gps_id)->get();
        $gps_transfer_ids = [];
        foreach ($gps_transfer_items as $gps_transfer_item) {
            $gps_transfer_ids[] = $gps_transfer_item->gps_transfer_id;
        }
        $gps_transfers = GpsTransfer::whereIn('id',$gps_transfer_ids)
                            ->with('fromUserTrackView:id,username')
                            ->with('toUserTrackView:id,username')
                            ->withTrashed()
                            ->get();
        return view('Warehouse::device-track-root-details',['gps_transfers' => $gps_transfers]);
    }
    
    // root gps transfer rule
    public function gpsRootTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsRootTransferNullRule(){
        $rules = [
          'gps_id' => 'required',
          'dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }


    // dealer gps transfer rule
    public function gpsDealerTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'sub_dealer_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
      ];
        return $rules;
    }

    // root gps transfer rule with null gps_id array
    public function gpsDealerTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'sub_dealer_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

    // sub dealer to trader gps transfer rule
    public function gpsSubDealerToTraderTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'trader_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
      ];
        return $rules;
    }

    // sub dealer to trader gps transfer rule with null gps_id array
    public function gpsSubDealerToTraderTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'trader_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

    // sub dealer gps transfer rule
    public function gpsSubDealerTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'client_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

    // sub dealer gps transfer rule with null gps_id array
    public function gpsSubDealerTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'client_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

    // trader to client gps transfer rule
    public function gpsTraderToClientTransferRule(){
        $rules = [
          'gps_id' => 'required|min:2',
          'client_user_id' => 'required',
          'scanned_employee_code' => 'required',
          'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

    // trader to client gps transfer rule with null gps_id array
    public function gpsTraderToClientTransferNullRule(){
        $rules = [
            'gps_id' => 'required',
            'client_user_id' => 'required',
            'scanned_employee_code' => 'required',
            'invoice_number' => 'required|regex:/^[a-zA-Z0-9]+$/u'
        ];
        return $rules;
    }

}
