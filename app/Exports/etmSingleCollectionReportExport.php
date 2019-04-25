<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Ticket\Models\TicketLog;
class EtmSingleCollectionReportExport implements FromView
{

	protected $EtmSingleCollectionExport;
	public function __construct($depot,$etm,$fromdate,$todate)
    {


         $closed_waybills = Waybill::select(
                'id',
                'date'
                )
                ->where('status',1)
                ->where('depot_id',$depot)
                ->get();
        $includes = [];
        foreach($closed_waybills as $waybill){
            $includes[] = $waybill->id;
        }
        $query =TicketLog::select(
            'id',
            'vehicle_id', 
            'imei',    
            'waybill_id',
            'ticket_fare',
            'ticket_fare',
            'toll_fare',  
            'total_amount',
            'device_time',
            'trip_id',
            \DB::raw('sum(total_amount) as income'),
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('sum(count) as count'),
            \DB::raw('sum(total_amount) as total_amount'),
            \DB::raw('sum(actual_amount) as actual_amount')
        )
         ->with('etm:id,name,imei')
         ->with('waybill:id,code')
        ->with('sumOfAdvanceBookingAmount')
        ->with('km')
         ->where('etm_id',$etm) 
         ->whereIn('waybill_id',$includes)
          ->where('depot_id',$depot)
         ->groupBy('date');
        if($fromdate){
            $query = $query->whereBetween('created_at',[$fromdate,$todate]);
        }
        $this->EtmSingleCollectionExport = $query->get();




        //  $query = TicketLog::where('depot_id',$depot)
        //   ->where('etm_id',$etm);
        //   // ->groupBy('etm_id',$etm);
        //    if($fromdate)
        // {
        //     $query = $query->whereDate('created_at', '>=', $fromdate)->whereDate('created_at', '<=', $todate);
        // }
        // $this->EtmSingleCollectionExport = $query->get();


    }


    public function view(): View
	{
	    return view('Exports::etm-single-collection-report', [
	        'EtmSingleCollectionExport' => $this->EtmSingleCollectionExport
	    ]);
	}
    
}

