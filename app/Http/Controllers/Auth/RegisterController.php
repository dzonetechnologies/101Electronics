<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    protected $redirectTo = '/account';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

 
    protected function create(array $data)
    {
        $Affected = User::create([
            'name' => $data['first_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 2,
            'status' => 1,
        ]);
        $Affected2 = Customers::create([
            'user_id' => $Affected->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return $Affected;
    }
    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('provider_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect()->route('home.account');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => 1,
                    'role_id' => 2,
                    'provider_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);
                $Affected2 = Customers::create([
                    'user_id' => $newUser->id,
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                Auth::login($newUser);
                return redirect()->route('home.account');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    //Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('provider_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect()->route('home.account');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => 1,
                    'role_id' => 2,
                    'provider_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);
                $Affected2 = Customers::create([
                    'user_id' => $newUser->id,
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                Auth::login($newUser);
                return redirect()->route('home.account');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}