<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function facebook()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => '876513946189146',
            'app_secret' => '5dcf55c4294494353b32563b1a3d92b6',
            'default_graph_version' => 'v7.0',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $helper->getAccessToken()
    }*/
}
