<?php

namespace App\Modules\Premium\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PremiumController extends Controller {

    //All states 
    public function premiumListPage()
    {
    	if(\Auth::user()->hasRole('fundamental')){
    		return view('Premium::premium-fundamental');
    	}
    	else if(\Auth::user()->hasRole('superior')){
    		return view('Premium::premium-superior');
    	}
    	else if(!\Auth::user()->hasRole(['superior','fundamental','pro'])){
    		return view('Premium::premium-client');
    	}
    }


}
