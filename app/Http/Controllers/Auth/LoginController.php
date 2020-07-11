<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
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

    private $helper;
    private $fb;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function facebook(\Illuminate\Http\Request $request)
    {
        $fb = new \Facebook\Facebook([
             'app_id' => env('FACEBOOK_APP_ID'),
             'app_secret' => env('FACEBOOK_APP_SECRET'),
             'default_graph_version' => 'v7.0',
         ]);

        $helper = $fb->getJavaScriptHelper();

        $accessToken = $helper->getAccessToken();

        if (! $accessToken->isLongLived())
            $accessToken = $fb->getOAuth2Client()->getLongLivedAccessToken($accessToken);

        $fb->setDefaultAccessToken($accessToken);

        $freshUser = $fb->get('me?fields=first_name,middle_name,last_name,email,picture')->getDecodedBody();
        $freshUser = [
            'name' => "$freshUser[first_name] " . ($freshUser['middle_name'] ?? ''),
            'last_name' => $freshUser['last_name'] ?? '',
            'email' => $freshUser['email'] ?? '',
            'password' => $accessToken,
            'profile_image' => $freshUser['picture']['data']['url'],
            'federated_by' => 'facebook',
            'federated_id' => $freshUser['id']
        ];

        if ($user = User::firstWhere('federated_id', $freshUser['federated_id']))
            $user->update($freshUser);
        else
            $user = User::create($freshUser);

        \Illuminate\Support\Facades\Auth::login($user, true);
    }
}
