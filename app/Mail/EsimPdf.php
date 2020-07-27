<?php

namespace App\Mail;
use \Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\User\Models\User;
use PDF;

class EsimPdf extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    protected $data;
    protected $from_date;
    public $to_date;
    public $nextMonth;
    public $year;
    public $role_count_total;
    public $role_count;




    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {   
        $this->data                 =   $data;
        $this->from_date            =   $data['from_date'];
        $this->to_date              =   $data['to_date'];
        $this->role_count_total     =   $data['role_count_total'];
        $this->role_count           =   $data['role_count'];
        $current_date               =   Carbon::now();
        $this->nextMonth            =   date('F', strtotime('next month'));
        $this->year                 =   date('Y', strtotime($current_date)) ;       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $pdf            =   PDF::loadView('Esim::esim-activation-details-download',$this->data);
        return $this->attachData($pdf->output(), "device plan expiry report.pdf")
            ->subject('List of devices expire in'.$this->nextMonth.'-'.$this->year)
            ->markdown('emails.esims.pdf')
            ->with([                       
                'from_date'         => $this->from_date,
                'to_date'           => $this->to_date,
                'nextMonth'         => $this->nextMonth,
                'year'              => $this->year,
                'role_count_total'  =>  $this->role_count_total,
                'role_count'        =>  $this->role_count
            ]); 
    }
}
