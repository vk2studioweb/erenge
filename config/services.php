<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'sicredi' => [
        'url'        => env('SICREDI_PIX_URL'),
        'client_id'  => env('SICREDI_CLIENT_ID'),
        'secret'     => env('SICREDI_CLIENT_SECRET'),
        'cert_path'  => storage_path(env('SICREDI_CERT_PATH')), 
        'key_path'   => storage_path(env('SICREDI_KEY_PATH')), // Removida a duplicação
    ],


    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];

