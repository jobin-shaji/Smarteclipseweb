<?php


namespace App\Modules\DataUssage\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\DataUssage\Models\DailyDataUsage;

class DataUsageController extends Controller
{

	public function usage(){
        return view('DataUssage::data-list');
	}

	public function datausageList(Request $request){

		$dailyDataUsage=DailyDataUsage::select(
												'gps_id',
												'data_size',
												'date_time'
											  )
						->with('Gps:id,name,imei,manufacturing_date')
						->get();
		   return DataTables::of($dailyDataUsage)
            ->addIndexColumn()
            ->make();

	}
    
}
