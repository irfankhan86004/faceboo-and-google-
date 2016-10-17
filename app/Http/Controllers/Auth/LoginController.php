<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use DB; 
use Auth;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, User $user)
    {
        Session::set('_login', trans('messages.login', ['display_name' => $user->display_name]));

        return redirect()->intended($this->redirectPath());
    }
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        $user = Socialite::driver('facebook')->user();
        $token = $user->token;
        dd($token);
//        // OAuth Two Providers
//
//        $refreshToken = $user->refreshToken; // not always provided
//        $expiresIn = $user->expiresIn;
//
//    // OAuth One Providers
//            $token = $user->token;
//            $tokenSecret = $user->tokenSecret;
//
//    // All Providers
//            $user->getId();
//            $user->getNickname();
//            $user->getName();
//            $user->getEmail();
//            $user->getAvatar();


    }
    
    public function getLoginFacebook(Request $request)
    {
        $serverName = $request->server->get('SERVER_NAME');
        $auth = $request->get('auth');
        
        if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
            \Hybrid_Endpoint::process();
        } else {
            try {                
                if ($auth == 'facebook'):
                    $config = $this->facebookConfig($serverName);
                elseif ($auth == 'google'): 
                    $config = $this->googleConfig($serverName);
                endif;

                $oauth = new \Hybrid_Auth($config);
                $provider = $oauth->authenticate(ucfirst($auth));
                $profile = $provider->getUserProfile();
               
                $authUser = $this->findOrCreateUser($profile, $auth);
 
                Auth::login($authUser, true);
                
                Session::set('_login', trans('messages.login', ['display_name' => $profile->displayName]));

                return redirect()->intended($this->redirectPath());
                
            } catch( Exception $e ){
                echo "Ooophs, we got an error: " . $e->getMessage();
            }
        }    
    }
    
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $user
     * @return User
     */
    private function findOrCreateUser($user, $auth)
    {
        if ($auth == 'facebook') {
            $authUser = User::where('facebook', $user->identifier)->orWhere('email', $user->email)->first();
            $authUser->facebook = $user->identifier;
            $authUser->save();
        } elseif ($auth == 'google') {
            $authUser = User::where('google', $user->identifier)->orWhere('email', $user->email)->first();
            
            $authUser->google = $user->identifier;
            $authUser->save();
        }

        if ($authUser){
            return $authUser;
        }
 
        if ($auth == 'facebook') {
            return User::create([
                'name' => $user->firstName,
                'email' => $user->email,
                'facebook' => $user->identifier,
            ]);
        } elseif ($auth == 'google') {
            return User::create([
                'name' => $user->firstName,
                'email' => $user->email,
                'google' => $user->identifier,
            ]);
        }
    }
    
    private function googleConfig($serverName)
    {
        $config = config('eloquent-oauth');
        
        return array(
            "base_url" => 'http://'.$serverName.'/fbAuth?auth=google',
            "providers" => array (
              "Google" => array (
                "enabled" => true,
                "keys"    => array ( "id" => $config['providers']['google']['client_id'], "secret" => $config['providers']['google']['client_secret']),
                  "scope"           => "https://www.googleapis.com/auth/userinfo.profile ". // optional
                                     "https://www.googleapis.com/auth/userinfo.email"   , // optional
                "access_type"     => "offline",   // optional
                "approval_prompt" => "force",     // optional
                "hd"              => "domain.com" // optional
        
          )));
    }

    /**
     * facebook configuration set
     * @return type
     */
    private function facebookConfig($serverName)
    {
        $config = config('eloquent-oauth');

        return array(
            "base_url" => 'http://'.$serverName.'/fbAuth',
            "providers" => array (
                "Facebook" => array (
                "enabled" => true,
                    "keys" => array ( "id" => $config['providers']['facebook']['client_id'], "secret" => $config['providers']['facebook']['client_secret']),
                    "scope" => "email", // optional
                    "display" => "popup" // optional
                ),
                'scope' => 'email',
                'trustForwarded' => false
            )
        );
    }
}
