<?php

namespace App\Http\Traits;

use Mail;

trait MailTrait
{
    /**
     * 
     * 
     */
    public function sendMail($from = null, $name_from = '', $to = null, $name_to = '', $template = null, $subject = '', $data = [])
    {
        try
        {
            // fallback cases
            $name_from  = ($name_from == '') ? $from : $name_from;
            $name_to    = ($name_to == '') ? $to : $name_to;

            if($template == null)
            {
                throw new Exception('A template is mandatory to send an email');
            }

            Mail::send('email.'.$template, $data, function($message) use($from, $name_from, $to, $name_to, $subject) {
                $message->to($to, $name_to)->subject($subject);
                $message->from($from, $name_from);
            });
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
        }
        
    }
}