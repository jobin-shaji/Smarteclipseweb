<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Traits\MailTrait;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, MailTrait;

    /** 
     * variables
     */
    public $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email    = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->sendMail(config('mail.from.address'),config('mail.from.name'),$this->email['to'],$this->email['toName'],$this->email['template'],$this->email['subject'],$this->email['data']);
    }
}
