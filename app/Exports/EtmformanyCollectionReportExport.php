<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Modules\WayBill\Models\Waybill;
use App\Modules\Ticket\Models\TicketLog;
class EtmformanyCollectionReportExport implements FromView
{

	protected $EtmformanyCollectionReportExport;
	public function __construct($depot,$fromdate,$todate)
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
        $query=TicketLog::select(
              'id',
              'imei',
              'waybill_id',
               'etm_id',
               'trip_id',
              \DB::raw('DATE(created_at) as date'),
              \DB::raw('sum(count) as count'),
              \DB::raw('sum(total_amount) as total_amount'),
              \DB::raw('sum(actual_amount) as actual_amount')
         )
         ->with('etm:id,name,imei')
         ->with('waybill:id,code')
        ->with('sumOfAdvanceBookingAmount')
        ->with('km')
        ->whereIn('waybill_id',$includes)
        ->where('depot_id',$depot)
        ->groupBy('etm_id');
      if($fromdate){
          $query = $query->whereDate('created_at', '>=', $fromdate)->whereDate('created_at', '<=', $todate);
      }
    	  $this->EtmformanyCollectionReportExport = $query->get();

      
    }


    public function view(): View
	{
	    return view('Exports::etm-formany-report', [
	        'EtmformanyCollectionReportExport' => $this->EtmformanyCollectionReportExport
	    ]);
	}
    
}

