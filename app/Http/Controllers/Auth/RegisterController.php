<?php

namespace App\Http\Controllers\Auth;

use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         return User::create([
            'username' => $data['username'],
            'role_id' => $data['role'],
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        //return redirect('home');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'mobile' => 'required|string|regex:/^\+?[0-9]{10,15}$/', 
        ]);
        
        // Create the user
        $user = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
        
        //file_put_contents('/var/www/smarteclipseweb/temp/log1.txt', date('Y-m-d H:i:s') . "User ID = ". $user->id ."\n", FILE_APPEND);
        $str='App\\Modules\\User\\Models\\User';
        $inserted = DB::insert("insert into model_has_roles (role_id,model_type,model_id) values (20,?,?)",[$str,$user->id]);
        $str='App\\Models\\User';
        $inserted = DB::insert("insert into model_has_roles (role_id,model_type,model_id) values (20,?,?)",[$str,$user->id]);
        
        
    
        // Optionally, log the user in
        //Auth::login($user);
    
        // Redirect or return response
        //return redirect()->route('home');
        return redirect()->route('login');
    }

}
