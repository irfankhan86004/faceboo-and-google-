<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Hash;
use Debugbar;
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
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function Validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'username' => 'required|max:255',
    //         'email' => 'required|email|max:255|unique:users',
    //         'password' => 'required|min:8|confirmed',
    //         'confirmPassword' => 'required|min:8|confirmed',
    //     ]);
    // }
    public function index(){
        // return redirect()->route('admin.post.index');
     return view('auth.register');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $request)
    {
       $user = new User;
        // dd($user);
         $data= $request->all();
          Debugbar::info(  $data);
      // dd($data);
        // $validator = Validator::make(
        //     array(
        //     'name' => $request->username,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'confirmPassword' => $request->confirmPassword
        //     ),
        //     array(
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required|min:6|confirmed',
        //     'confirmPassword'=> 'required|min:6|confirmed',
        //     ) );
      $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:1',
            'confirmPassword'=> 'required|min:1'
        ]);


        if($validator->fails())
        {
            Debugbar::info($validator->fails());
            Debugbar::info('nicess');
            // return view('auth/register',array('what'=>'dand sppsd ttp '));
            return view('auth/register');
        }
        else if($request->password != $request->confirmPassword)
        {
            return view('auth/register');
        }
        else {
            $pass = $request->password;
            $pass = hash::make($pass);
            $user->first_name = $request->username;
            $user->password = $pass;
            $user->email = $request->email;
            $user->is_admin=1; //set the register user as normal user
            $user->save();  


         return redirect('/admin');
        }


        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);
    }
}
