<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\Alert\Models\Alert;
use App\Modules\Gps\Models\GpsData;
use App\Modules\Gps\Models\Gps;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Vehicle\Models\DailyKm;
class TotalKMReportExport implements FromView
{
	protected $totalkmReportExport;
	public function __construct($client,$vehicle)
    {   
        if($vehicle!=0)
        {
            $vehicle_details =Vehicle::withTrashed()->find($vehicle);
            $single_vehicle_ids = $vehicle_details->gps_id;
        }
        else
        {
            $vehicle_details =Vehicle::where('client_id',$client)->withTrashed()->get();
            foreach($vehicle_details as $vehicle_detail){
                $single_vehicle_id[] = $vehicle_detail->gps_id; 
            }
        }
        $query =Gps::select(
            'id', 
             'km'
        )
        ->with('vehicle') 
        ->orderBy('id', 'desc');           
         if($vehicle==0 || $vehicle==null)
        {        
            $query = $query->whereIn('id',$single_vehicle_id);           
        }
        else
        {
            $query = $query->where('id',$single_vehicle_ids);               
        }                     
        $this->totalkmReportExport = $query->get();   

    }
    public function view(): View
	{
        // dd($this->totalkmReportExport); 
       return view('Exports::total-km-report', [
            'totalkmReportExport' => $this->totalkmReportExport
        ]);
	}
    
}

