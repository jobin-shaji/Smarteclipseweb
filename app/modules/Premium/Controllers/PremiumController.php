<?php

namespace App\Modules\Premium\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PremiumController extends Controller {

    //All states 
    public function premiumListPage()
    {
        return view('Premium::premium');
    }


}
