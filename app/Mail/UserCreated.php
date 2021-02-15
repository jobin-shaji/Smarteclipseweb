<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\User\Models\User;

class UserCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    protected $password;
    protected $user;
    protected $name;
    public $url;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $name, $password)
    {
        $this->user = $user;
        $this->name  = $name;
        $this->password = $password;
        $this->url = "http://www.smarteclipse.com/login";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.created')
                    ->with([
                        'password'  => $this->password,
                        'username' => $this->user->username,
                        'name'      => $this->name
                    ]); 
    }
}
