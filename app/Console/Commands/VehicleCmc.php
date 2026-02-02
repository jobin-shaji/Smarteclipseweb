<?php

namespace App\Console\Commands;
use \Carbon\Carbon;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Gps\Models\GpsOrder;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Esim\Models\SimActivationDetails;
use App\Modules\Settings\Models\Settings;
use App\Jobs\MailJob;
use App\Http\Traits\MqttTrait;
use App\Mail\EsimPdf;
use Illuminate\Support\Facades\Mail;
use \DB;
use PDF;

use Illuminate\Console\Command;




class VehicleCmc extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate invoice PDFs for eligible records';

    public function handle()
    {
        $today = Carbon::today();

        // Example: loop through users/customers/contracts
        $records = (new Vehicle())->getVehicleListBasedOnClient(1778);  
        
        $ordid=1666;
        $latestOrder = GpsOrder::orderBy('ordid','DESC')->first();
        
        if( $latestOrder ){
            $ordid= $latestOrder->ordid + 1;
            $orderno = 'VIOT/2024-'.date("Y").'/'. $ordid;
           
        }else{
            $orderno = 'VIOT/2024-'.date("Y").'/1666';
        }
        foreach ($records as $record) {

            if($record->inv_generated){
                // already generated


                $Vehicle=Vehicle::find($record->id);

                          //return $validy;
                $previous = Carbon::parse($record->next_due_date);
               
                $today = Carbon::today();
    
                $diffInMonths = $previous->diffInMonths($today, false);

                if ($diffInMonths >= 6) {

                    $halfYears = floor($diffInMonths / 6);

                    $remainingMonths = $diffInMonths % 6;
                    //
                    $uptDueDate = $adjustedDate->copy()->addMonths($diffInMonths-$remainingMonths);
                            // Next due date = today + remaining months
                    $nextDueDate =$uptDueDate->copy()->addMonths(6);
            


                    $order= new GpsOrder();
                    $order->order_id = $orderno;
                    $order->gps_id = $record->gps->id;
                    $order->delivery_name ='KSRTC';
                    $order->delivery_address = 'ksrtc';
                    $order->total_amount =  $halfYears*600;
                    $order->payment_status = 1;
                    $order->ordid =$ordid;
                    $order->save();
                    $Vehicle->inv_generated=1;
                    $Vehicle->next_due_date=$uptDueDate->toDateString();
                    $Vehicle->save();

                }

            }else{
                $installation_date=optional($record->gps)->installation_date ??"";
                //return $validy;
                $previous = Carbon::parse($installation_date);
                $adjustedDate = $previous->copy()->addYears(2)->addMonth();
                $today = Carbon::today();
    
        // Total difference in months
               $diffInMonths = $adjustedDate->diffInMonths($today, false);

            if ($diffInMonths >= 6) {

              
                //
                $remainingMonths = $diffInMonths % 6;
        //
                $uptDueDate = $adjustedDate->copy()->addMonths($diffInMonths-$remainingMonths);
                // Next due date = today + remaining months
                $nextDueDate =$uptDueDate->copy()->addMonths(6);

                $halfYears = floor($diffInMonths / 6);


                $order= new GpsOrder();
                $order->order_id = $orderno;
                $order->gps_id = $record->gps->id;
                $order->delivery_name ='KSRTC';
                $order->delivery_address = 'ksrtc';
                $order->total_amount =  $halfYears*600;
                $order->payment_status = 1;
                $order->ordid =$ordid;
                $order->save();

                $Vehicle->inv_generated=1;
                $Vehicle->next_due_date=$uptDueDate->toDateString();
                $Vehicle->save();
            }
    
        // Remaining months after dividing by half-yearly (6 months)
      
         }
            // Assume record has a "previous_date" field (MM/DD/YYYY format)
           

            $this->info("Invoice generated");

        }

        return Command::SUCCESS;
    }
}
