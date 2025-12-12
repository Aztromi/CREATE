<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\LogsLogin;

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
    | vendor/laravel/ui/auth-backend/AuthenticatesUsers.php
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
        $this->request = $request;
    }

    public function redirectTo(){

        $verifiedValue = [-1, 0, 1];
        $adminType = ['super', 'og', 'bdu', 'editor'];
        $user = Auth::user();

        $user->loginLogs()->create([
            'ip' => $this->request->ip(),
        ]);

        

        if(in_array($user->verified, $verifiedValue) && $user->type === 'normal' && $user->user_role_id === null){
            // return redirect()->route('user.index');
            return  RouteServiceProvider::USER;
        }
        else if(in_array($user->type, $adminType) && $user->user_role_id === 1){
            // return redirect()->route('admin.index');
            return RouteServiceProvider::ADMIN;
        }




    }

    protected function authenticated(Request $request, $user)
    {

        if($user->type == 'normal')
        {
            if($user->verified == -1 && $user->profile->is_new == 1)
            // if($user->profile->is_new == 1)
            {
                return redirect()->route('user.member.message.memberWelcome');
            }
            else if($user->profile->has_profile_reminder == 1)
            {
                return redirect()->route('user.member.message.accountUpdate');
            }
        }
        


        
        // elseif ($user->isCustomer()) {
        //     return redirect()->route('customer.dashboard');
        // } else {
        //     return redirect()->route('home');
        // }

    }






}
