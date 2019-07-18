<?php


namespace App\Modules\SmsUsage\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\DataUsage\Models\DailyDataUsage;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\Gps;
use DataTables;



class SmsUsageController extends Controller
{

	public function usage(){

		$vehicle_device = Vehicle::select(
                'gps_id'
                )                
                ->get();
        $single_gps = [];
        foreach($vehicle_device as $device){
            $single_gps[] = $device->gps_id;
        }
        $devices=Gps::select('id','name','imei')               
                ->whereIn('id',$single_gps)
                ->get();

        return view('SmsUsage::sms-list',['devices'=>$devices]);
	}

	public function datausageList(Request $request){
		$gps_id=$request->gps_id;
		$client=$request->client;
		$from=$request->from_date;
		$to=$request->to_date;


		$dailyDataUsage=DailyDataUsage::select(
			'gps_id',
			'data_size',
			'date_time'
		 );
		if($gps_id==null)
		{
			$dailyDataUsage=$dailyDataUsage->with('Gps:id,name,imei,manufacturing_date');
		}
		else
		{
			$dailyDataUsage=$dailyDataUsage->with('Gps:id,name,imei,manufacturing_date')
			->where('gps_id',$gps_id);
			 
		}
		if($from){
            $search_from_date=date("Y-m-d", strtotime($from));
                $search_to_date=date("Y-m-d", strtotime($to));
                $dailyDataUsage = $dailyDataUsage->whereDate('date_time', '>=', $search_from_date)->whereDate('date_time', '<=', $search_to_date);
        	}
						
			$dailyDataUsage=$dailyDataUsage->get();
		   return DataTables::of($dailyDataUsage)
            ->addIndexColumn()
            ->make();

	}
    
}
