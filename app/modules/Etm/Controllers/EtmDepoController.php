<?php 

namespace App\Modules\Etm\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Etm\Models\Etm;
use App\Modules\Depot\Models\Depot;

use DataTables;

class EtmDepoController extends Controller {

    //Display all etms
	public function etmListPage()
    {
		return view('Etm::etm-depo-list');
	}

	//returns etm as json 
    public function getEtms(Request $request)
    {
        $depot=$request->data['depot'];
        // $depot=\Auth::user()->depot->first()->id;
        $etm = Etm::select(
                'id',
                'name',
            	'imei',
            	'purchase_date',
            	'version',
                'depot_id')
                ->with('depot:id,name')
                ->where('depot_id',$depot)
                ->get();
            return DataTables::of($etm)
            ->addIndexColumn()
            ->make();
    }
}