<?php

namespace App\Console\Commands;
use \Carbon\Carbon;
use App\Modules\Root\Models\Root;
use App\Modules\User\Models\User;
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

class Esim extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esim:pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expiring esim details pdf';

    /**
     * Trip date 
     *
     * @var date 
     */
    protected $exp_date;

     /**
     * Trip source table 
     *
     * @var date 
     */
    protected $source_table;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {
        $this->getEsimMail();
        echo "processing completed !!"."\n";
        

    }

    /**
     * Sending esim pdf mail on every month 20th
     *
     * 
     */
    public function getEsimMail()
    {
        $firstDateOfNextMonth =strtotime('first day of next month') ;
        $firstDay = date('Y-m-d', $firstDateOfNextMonth);
        $lastDateOfNextMonth =strtotime('last day of next month') ;
        $lastDay = date('Y-m-d', $lastDateOfNextMonth);
        $search_key=null;
        $download_type='pdf';
        $esim_list                          =   (new SimActivationDetails())->getSimActivationList($search_key,$firstDay,$lastDay,$download_type);
        $settings                           =   (new Settings())->getSettings();
        $role_count                         =   (new SimActivationDetails())->roleBasedCount($search_key,$firstDay,$lastDay,$download_type);
        $role_count_data                    =   [];    
        $role_count_total                   =   0;   
       if( $role_count )
       {                
            foreach($role_count as $item)
            {
                $role_count_total = $role_count_total + $item->count;
                $role_count_data [$item->role]  =[
                    "count"  => $item->count
                ];
            }
       } 
       $email=[];
       foreach($settings as $setting)
        {
            $name []= $setting->name;
            $email[] = $setting->email;            
        }
        $data            =   ['esim_lists' => $esim_list,'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => $firstDay, 'to_date' => $lastDay,'role_count'=>$role_count_data, 'role_count_total' =>  $role_count_total,'generated_by' => 'VST Mobility Solutions ( Manufacturer )'];
        Mail::to($email[0])->cc($email[1])->send(new EsimPdf($data));
    }

    

}

