<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailPasswordReset;
use App\Models\Admin\MailConfig;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\Admin\Usuarios;
use DB;
use Redirect;
use Throwable;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function showResetForm($token)
    {
        $tokenData = DB::table('vpr_login_users_resets')->where('token', $token)->first();

        if (!$tokenData)
            return redirect()->to('/');
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $password = $request->password;
        $tokenData = DB::table('vpr_login_users_resets')->where('token', $request->token)->first();

        $user = Usuarios::where('email', $tokenData->email)->first();
        if (!$user)
            return redirect()->to('/login');

        $user->password = bcrypt($password);
        $user->save();

        DB::table('vpr_login_users_resets')->where('email', $user->email)->delete();

        return "success";
    }

}