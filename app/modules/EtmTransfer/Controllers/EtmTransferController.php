<?php
namespace App\Modules\EtmTransfer\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\EtmTransfer\Models\EtmTransfer;
use App\Modules\Etm\Models\Etm;
use App\Modules\Depot\Models\Depot;
use DataTables;
class EtmTransferController extends Controller {
    // etm transfer list
    public function getList() 
    {
        return view('EtmTransfer::etm-transfer-list');
    }

    // etm transfer list data
    public function getListData() 
    {
 
        $etm_transfer = EtmTransfer::select('id', 'etmID', 'from_depot', 'to_depot', 'tarnferDate')
        ->with('fromDepotDetails:id,name')
        ->with('toDepotDetails:id,name')
        ->with('etmDetails:id,name')
        ->get();
        return DataTables::of($etm_transfer)
        ->addIndexColumn()
        ->make();
    }
    // create etm transfer
    public function createEtmTransfer() 
    {
       
        $etms = ETM::select('id', 'name', 'imei')
        ->get();
        $depots = Depot::select('id', 'name', 'code')
        ->get();
        return view('EtmTransfer::etm-transfer', ['etms' => $etms, 'depots' => $depots]);
    }
    // save etm transfer
    public function saveTransfer(Request $request) 
    {
       
        $rules = $this->etmTransferRule();
        $this->validate($request, $rules);
        $etmTransfer = EtmTransfer::create([
          "etmID" => $request->etm, 
          "from_depot" => $request->from_depot, 
          "to_depot" => $request->to_depot,
          "tarnferDate" => date('Y-m-d H:i:s')]
          );
        // update employee table
        $etmID = $request->etm;
        $etm = ETM::find($etmID);
        $etm->depot_id = $request->to_depot;
        $etm->save();
        $request->session()->flash('message', 'ETM Transfer successfully completed!');
        $request->session()->flash('alert-class', 'alert-success');
        return redirect(route('etm-transfers'));
    }
    // etm depot details
    public function depotData(Request $request) 
    {
        $etm = Etm::find($request->etmID);
        $etm->depot;
               
        return response()->json(array('response' => 'success', 'etm' => $etm));
    }
    
    // etm transfer rule
    public function etmTransferRule() {
        $rules = [
          'etm' => 'required',
         'from_depot' => 'required',
          'to_depot' => 'required'];
        return $rules;
    }
}
