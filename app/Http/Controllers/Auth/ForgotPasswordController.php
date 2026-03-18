<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailPasswordReset;
use App\Models\Admin\MailConfig;
use App\Models\Admin\Usuarios;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use DB;
use Mail;
use Throwable;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {

        $user = Usuarios::where('email', $request->email)->where('id_class', $request->type)->first();

        if (!$user) {
            return "false";
        }

        $token = md5(rand(1, 10) . microtime());

        DB::table('vpr_login_users_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'id_class' => $request->type
        ]);

        try {
            Mail::send(new MailPasswordReset(['email' => $request->email, 'name' => $user->name], $token));
        } catch (Throwable $th) {
            return "failed";
        }

        return "success";
    }

}