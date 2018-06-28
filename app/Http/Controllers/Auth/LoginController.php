<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \VatsimSSO;
use App\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login with VATSIM SSO
     * @return void
     */
    public function login()
    {
        $returnUrl = route("validate");
        VatsimSSO::login(
            $returnUrl, function ($key, $secret, $url) {
            Session::put('vatsimAuth', compact('key', 'secret'));
            header('Location: ' . $url);
            echo $url;
        }, function ($e) {
            throw new \Exception("Could not authenticate: " . $e->getMessage());
        });
    }

    /** Validate Login
     *
     * @param \App\Http\Controllers\Auth\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validateLogin(Request $request)
    {
        $session = Session::get('vatsimAuth');
        $status = true;

        VatsimSSO::validate(
            $session['key'], $session['secret'],
            $request->input('oauth_verifier'), function ($user, $request) {
            Session::forget('vatsimAuth');

            // Process user data
            if ($request->result == "success") {
                //If user exists: log in. Redirect home.
                //If user doesn't exist: Create. Log in. Redirect home.
                $vatsimID = $user->id;
                $firstName = $user->name_first;
                $lastName = $user->name_last;
                $email = $user->email;

                $userDb = User::firstOrCreate(['cid' => $vatsimID], [
                    'cid'        => $vatsimID,
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'email'      => $email
                ]);
                Auth::login($userDb, true);
            } else {
                $status = false;
            }
        });

        if (!$status) {
            flash('Could not log in with VATSIM.')->error();
        } else {
            flash('Login successful.')->success();
        }

        return redirect('/');
    }
}
