<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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

    protected function authenticated(Request $request, $user)
    {
        /*echo '<pre>';
        echo print_r($request->all());
        echo '</pre>';
        exit();*/

        $PageType = "";
        if ($request->has('pageType')) {
            $PageType = $request->post('pageType');
        }
        if (isset($user)) {
            if ($user->status != 1) {
                Auth::logout();
                return redirect('/login')->with('error', 'Your account has been deactivated. Please contact one-0-one admin.');
            } else {
                if (Auth::user()->role_id == 1) {
                    return redirect()->route('dashboard');
                } else {
                    if ($PageType == 'Checkout') {
                        return redirect()->route('CheckoutRoute');
                    } else {
                        return redirect()->route('home.account');
                    }
                }
            }
        }

        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('HomeRoute');
    }

}