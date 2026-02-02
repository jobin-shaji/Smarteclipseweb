<?php

namespace App\Modules\TrafficRules\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\TrafficRules\Models\TrafficRule;
use App\Modules\TrafficRules\Models\Country;
use App\Modules\TrafficRules\Models\State;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class TrafficRuleController extends Controller 
{
    
    // traffic rule list
    public function trafficRuleList()
    {
       return view('TrafficRules::traffic-rule-list'); 
    }

    // traffic rule list data
    public function getTrafficRuleList()
    {

        $traffic_rule = TrafficRule::select(
                    'id',
                    'country_id',
                    'state_id',
                    'speed',
                    'deleted_at'
                    )
                ->withTrashed()
                ->with('country:id,name')
                ->with('state:id,name')
                ->get();
        return DataTables::of($traffic_rule)
            ->addIndexColumn()
            ->addColumn('action', function ($traffic_rule) {
                $b_url = \URL::to('/');
                if($traffic_rule->deleted_at ==null){
                    return 
                        "<a href=".$b_url."/traffic-rule/".Crypt::encrypt($traffic_rule->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                        <a href=".$b_url."/traffic-rule/".Crypt::encrypt($traffic_rule->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                        <button onclick=deleteTrafficRule(".$traffic_rule->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                        </button>";
                }else{
                    return 
                        "<button onclick=activateTrafficRule(".$traffic_rule->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Activate
                        </button>";
                }
                
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create traffic rule
    public function createTrafficRule()
    {
        $countries=Country::select([
            'id',
            'name'
            ])
            ->get();
        return view('TrafficRules::traffic-rule-add',['countries'=>$countries]);
    }
    // save traffic rule
    public function saveTrafficRule(Request $request)
    {
        $rules = $this->trafficRuleCreateRules();
        $this->validate($request, $rules);
        $traffic_rule = TrafficRule::create([
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'speed' => $request->speed
           ]);
        $request->session()->flash('message', 'New traffic rule created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 

        return redirect(route('traffic-rule.details',Crypt::encrypt($traffic_rule->id)));
    }

    //get state in dependent dropdown
    public function getStateList(Request $request)
    {
        $countryID=$request->countryID;
        $states = State::select(
                'id',
                'name'
                )
                ->where("country_id",$countryID)
                ->get();
        return response()->json($states);
    }

    // traffic rule details
    public function detailsTrafficRule(Request $request)
     {
        $decrypted_id = Crypt::decrypt($request->id);
        $traffic_rule=TrafficRule::find($decrypted_id);
        if($traffic_rule==null){
            return view('TrafficRules::404');
        } 
        return view('TrafficRules::traffic-rule-details',['traffic_rule' => $traffic_rule]);
     }
    // edit traffic rule
    public function editTrafficRule(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $traffic_rule = TrafficRule::find($decrypted_id);
        if($traffic_rule == null)
        {
            return view('TrafficRules::404');
        }
        $countries=Country::select('id','name')
                ->get();
        $states=State::select('id','name')
                ->get();
        return view('TrafficRules::traffic-rule-edit',['traffic_rule' => $traffic_rule,'countries' => $countries,'states' => $states]);
    }

    // update traffic rule
    public function updateTrafficRule(Request $request)
    {
        $traffic_rule = TrafficRule::find($request->id);
        if($traffic_rule == null){
           return view('TrafficRule::404');
        }
        $rules = $this->trafficRuleUpdateRules();
        $this->validate($request, $rules);

        $traffic_rule->country_id = $request->country_id;
        $traffic_rule->state_id = $request->state_id;
        $traffic_rule->speed = $request->speed;
       
        $traffic_rule->save();

        $encrypted_traffic_rule_id = encrypt($traffic_rule->id);
        $request->session()->flash('message', 'Traffic rule details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('traffic-rule.edit',$encrypted_traffic_rule_id));  
    }

    // delete traffic rule
    public function deleteTrafficRule(Request $request)
    {
        $traffic_rule=TrafficRule::find($request->id);
        if($traffic_rule == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Traffic rule does not exist'
            ]);
        }
        $traffic_rule->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Traffic rule deleted successfully'
        ]);
        
    }

    // acivate traffic rule
    public function activateTrafficRule(Request $request)
    {
        $traffic_rule=TrafficRule::withTrashed()->find($request->id);
        if($traffic_rule == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Traffic rule does not exist'
            ]);
        }
        $traffic_rule->restore(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Traffic rule restored successfully'
        ]);
        
    }
    
    // traffic rule create rules
    public function trafficRuleCreateRules()
    {
        $rules = [
            'country_id' => 'required',
            'state_id' => 'required',
            'speed' => 'required'
        ];
        return  $rules;
    }
    // traffic rule update rules
    public function trafficRuleUpdateRules()
    {
        $rules = [
            'country_id' => 'required',
            'state_id' => 'required',
            'speed' => 'required'
        ];
        return  $rules;
    }

}
