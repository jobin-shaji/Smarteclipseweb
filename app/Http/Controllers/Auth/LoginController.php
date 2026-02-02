<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // eugene added
    function isValidMobile($input) {
        // Example criteria: numeric and length between 10 and 15 digits
        return is_numeric($input) && strlen($input) >= 10 && strlen($input) <= 15;
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        try{
        //$requestData = json_encode($request->all(), JSON_PRETTY_PRINT);

        $input = $request->all();

        
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : ($this->isValidMobile($request->input('login')) ? 'mobile' : 'username');
        $credentials = [$login_type => $input['login'], 'password' => $input['password']];
        

        // Attempt to authenticate the user
        if (auth()->attempt($credentials)) {
            return redirect()->intended($this->redirectTo);
        }

        //$request->merge([$login_type => $input['login']]);
        //if (auth()->attempt([$login_type => $input['login'], 'password' => $input['password']])) {
          //  return redirect()->intended($this->redirectTo);
        //}
        
    } catch (ValidationException $e) {
        // Log validation errors
        //Log::error('Validation Errors: ', $e->errors());

        // Optionally, you can rethrow the exception if you want
        // throw $e;

        $errors = $e->errors();
        $errorMessages = [];

        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                $errorMessages[] = ucfirst($field) . ': ' . $message;
            }
        }

        $errorString = implode(' | ', $errorMessages);


        file_put_contents('/var/www/smarteclipseweb/temp/log1.txt', date('Y-m-d H:i:s') . $errorString."\n", FILE_APPEND);
        // Redirect back with errors
        //return redirect()->back()->withInput($request->all())->withErrors($e->errors());
    }
        file_put_contents('/var/www/smarteclipseweb/temp/log1.txt', date('Y-m-d H:i:s') . "At login 4"."\n", FILE_APPEND);

        return redirect()->back()->withInput($request->only('login', 'remember'))->withErrors([
            'login' => 'These credentials do not match our records..',
        ]);
    }
    // eugene added end



    public function username()
    {
        return 'username';
    }

}
