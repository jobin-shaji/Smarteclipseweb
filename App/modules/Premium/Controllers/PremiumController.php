<?php

namespace App\Modules\Premium\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Subscription\Models\Subscription;
use Illuminate\Support\Facades\Crypt;

class PremiumController extends Controller {

    //All states 
    public function premiumListPage()
    {
        $subscription=Subscription::all();
    	if(\Auth::user()->hasRole('fundamental')){
    		return view('Premium::premium-fundamental');
    	}
    	else if(\Auth::user()->hasRole('superior')){
    		return view('Premium::premium-superior');
    	}
        else if(\Auth::user()->hasRole('pro')){
            return view('Premium::premium-pro');
        }
    	else if(!\Auth::user()->hasRole(['superior','fundamental','pro'])){
    		return view('Premium::premium-client');
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
