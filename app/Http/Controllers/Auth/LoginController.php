<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Request;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Redirector;
use Auth;
use Session;

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
    // protected $redirectTo = '/admin/home';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }
    
    public function logout()
    {
        if(Auth::check()){
            switch(Auth::user()->id_class) {
                case 1:
                    $goReturn = '/login';
                    break;
                case 2:
                    $goReturn = '/entrar';
                    break;
            }
            Auth::logout();
            Session::flush();
    
            return redirect($goReturn);
        }

        return redirect('/home');

    }

    public function redirectTo()
    {
        if(Session::has('baseUrl'))
        {
            $baseUrl = Session::get('baseUrl');
            Session::pull('baseUrl');
        } else {
            switch(Auth::user()->id_class) {
                case 1:
                    $baseUrl = url('/admin');
                    break;
                case 2:
                    $baseUrl = url('/lojista');
                    break;
            }
        }
        return $baseUrl;
    }

}
