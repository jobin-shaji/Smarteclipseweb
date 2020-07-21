<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\User\Models\User;

class UserCreatedWithoutEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    protected $password;
    protected $user;
    protected $name;
    protected $username;

    public $url;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $name, $password,$username)
    {
        // dd($username);
        $this->user = $user;
        $this->name  = $name;
        $this->password = $password;
        $this->username = $username;
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
                        'username'  => $this->username,
                        'name'      => $this->name
                    ]); 
    }
}
