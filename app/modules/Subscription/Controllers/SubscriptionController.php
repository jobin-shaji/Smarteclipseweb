<?php

namespace App\Modules\Subscription\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Subscription\Models\Subscription;
use App\Modules\TrafficRules\Models\Country;
use App\Modules\Subscription\Models\Plan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class SubscriptionController extends Controller 
{
    
    // Subscription list
    public function subscriptionList()
    {
       return view('Subscription::subscription-list'); 
    }

    // Subscription list data
    public function getSubscriptionList()
    {

        $subscription = Subscription::select(
                    'id',
                    'plan_id',
                    'country_id',
                    'amount',
                    'deleted_at'
                    )
                ->withTrashed()
                ->with('country:id,name')
                ->with('plan:id,name')
                ->get();
        return DataTables::of($subscription)
            ->addIndexColumn()
            ->addColumn('action', function ($subscription) {
                $b_url = \URL::to('/');
                if($subscription->deleted_at ==null){
                    return 
                        "<a href=".$b_url."/subscription/".Crypt::encrypt($subscription->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                        <a href=".$b_url."/subscription/".Crypt::encrypt($subscription->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>";
                //         <button onclick=deleteSubscription(".$subscription->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate
                //         </button>
                // }else{
                //     return 
                //         "<button onclick=activateSubscription(".$subscription->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Activate
                //         </button>";
                }
                
             })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    // create subscription
    public function createSubscription()
    {
        $countries=Country::select([
            'id',
            'name'
            ])
            ->get();
        $plans=Plan::select([
            'id',
            'name'
            ])
            ->get();
            // dd($plans);
        return view('Subscription::subscription-add',['countries'=>$countries,'plans'=>$plans]);
    }
    // save subscription
    public function saveSubscription(Request $request)
    {
        $rules = $this->subscriptionCreateRules();
        $this->validate($request, $rules);
        $plan_id=$request->plan_id;
        $country_id=$request->country_id;
        $amount=$request->amount;
        $subscription_history=Subscription::where('country_id',$country_id)->where('plan_id',$plan_id)->count();
        if($subscription_history == 0){
            $subscription = Subscription::create([
                'plan_id' => $plan_id,
                'country_id' => $country_id,
                'amount' => $amount
                ]);
            $request->session()->flash('message', 'New subscription plan created successfully!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('subscription.details',Crypt::encrypt($subscription->id)));
        }else{
            $request->session()->flash('message', 'This plan in this country is already exist!'); 
            $request->session()->flash('alert-class', 'alert-success'); 
            return redirect(route('subscription'));
        }
    }

    // subscription details
    public function detailsSubscription(Request $request)
     {
        $decrypted_id = Crypt::decrypt($request->id);
        $subscription=Subscription::find($decrypted_id);
        if($subscription==null){
            return view('Subscription::404');
        } 
        return view('Subscription::subscription-details',['subscription' => $subscription]);
     }
    // edit subscription
    public function editSubscription(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $subscription = Subscription::find($decrypted_id);
        if($subscription == null)
        {
            return view('Subscription::404');
        }
        $countries=Country::select('id','name')
                ->get();
        $plans=Plan::select('id','name')
                ->get();
        return view('Subscription::subscription-edit',['subscription' => $subscription,'countries' => $countries,'plans' => $plans]);
    }

    // update subscription
    public function updateSubscription(Request $request)
    {
        $subscription = Subscription::find($request->id);
        if($subscription == null){
           return view('Subscription::404');
        }
        $rules = $this->subscriptionUpdateRules();
        $this->validate($request, $rules);
        $subscription->amount = $request->amount;
        $subscription->save();

        $encrypted_subscription_id = encrypt($subscription->id);
        $request->session()->flash('message', 'subscription plan details updated successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('subscription.details',$encrypted_subscription_id));  
    }

    // delete subscription
    public function deleteSubscription(Request $request)
    {
        $subscription=Subscription::find($request->id);
        if($subscription == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Subscription plan does not exist'
            ]);
        }
        $subscription->delete(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Subscription plan deleted successfully'
        ]);
        
    }

    // acivate subscription
    public function activateSubscription(Request $request)
    {
        $subscription=Subscription::withTrashed()->find($request->id);
        if($subscription == null){
           return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'Subscription plan does not exist'
            ]);
        }
        $subscription->restore(); 
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Subscription plan restored successfully'
        ]);
        
    }
    
    // subscription create rules
    public function subscriptionCreateRules()
    {
        $rules = [
            'plan_id' => 'required',
            'country_id' => 'required',
            'amount' => 'required'
        ];
        return  $rules;
    }
    // subscription update rules
    public function subscriptionUpdateRules()
    {
        $rules = [
            'amount' => 'required'
        ];
        return  $rules;
    }

}
