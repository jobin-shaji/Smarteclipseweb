<?php
namespace App\Modules\Esim\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Alert\Models\Alert;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Esim\Models\SimActivationDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use DataTables;
class EsimController extends Controller {
     /**
     * 
     * @author PMS
     * 
     */
    public function getEsimDetails()
    {
        $esim_list = (new SimActivationDetails())->getSimActivationList();
        return view('Esim::esim-activation-details-list')->with([ 'lists' => $esim_list ]);   
    }
    public function getDetails(Request $request)
    {
        $esim_details    = (new SimActivationDetails())->getSimActivationDetails(Crypt::decrypt($request->id));
        if($esim_details == null)
        {
            return view('Esim::404');
        }
        return view('Esim::esim-activation-details',['esim' => $esim_details]);
    }
}
