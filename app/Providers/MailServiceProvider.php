<?php

namespace App\Providers;

use App\Models\Site\MailConfig;
use Illuminate\Support\ServiceProvider;
use Schema;
use DB;
use Config;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        try {
            $connection = DB::connection()->getPdo();

            if ($connection && Schema::hasTable('vpr_configuration_mail')) {
            
                $mail_config = DB::table('vpr_configuration_mail')
                    ->where('status', 1)
                    ->where('delete', 0)
                    ->first(['*']);
    
                if (!empty($mail_config)) {
                    \Config::set('mail.driver', 'smtp');
                    \Config::set('mail.host', $mail_config->smtp);
                    \Config::set('mail.port', $mail_config->smtp_port);
                    \Config::set('mail.username', $mail_config->mail_send);
                    \Config::set('mail.password', $mail_config->password_mail_send);
                    \Config::set('mail.encryption', $mail_config->ssl ? 'ssl' : 'tls');
                    \Config::set('mail.from.address', $mail_config->mail_send);
                    \Config::set('mail.from.name', 'VK2');
                }
            }
        } catch (\Throwable $th) {

        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}