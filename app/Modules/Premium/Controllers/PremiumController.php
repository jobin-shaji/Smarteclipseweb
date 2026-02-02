<?php

namespace App\Modules\Premium\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Subscription\Models\Subscription;
use App\Modules\Subscription\Models\Plan;
use Illuminate\Support\Facades\Crypt;

class PremiumController extends Controller {

    //All states 
    public function premiumListPage()
    {
        $subscription=Plan::all();
    	if(\Auth::user()->hasRole('fundamental')){
    		return view('Premium::premium-fundamental',['subscription'=>$subscription]);
    	}
    	else if(\Auth::user()->hasRole('superior')){
    		return view('Premium::premium-superior',['subscription'=>$subscription]);
    	}
        else if(\Auth::user()->hasRole('pro')){
            return view('Premium::premium-pro',['subscription'=>$subscription]);
        }
    	else if(!\Auth::user()->hasRole(['superior','fundamental','pro'])){
    		return view('Premium::premium-client',['subscription'=>$subscription]);
    	}
    }

    public function premiumSchoolListPage()
    {
        if(\Auth::user()->hasRole('school_premium')){
            return view('Premium::premium-school-premium');
        }
        else if(!\Auth::user()->hasRole(['school_premium'])){
            return view('Premium::premium-school');
        }
    }


}
