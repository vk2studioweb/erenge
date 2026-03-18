<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="background: url({{ config('app.background_login_admin', '') }}) no-repeat center center fixed;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ config('app.namePainel', 'http://www.vk2.com.br') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <title>{{ config('app.namePainel', 'Painel Administrativo') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/ui-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/applogin.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/App/jquery.js') }}" ></script>
    <script src="{{ asset('js/Admin/jquery.validation.js') }}" ></script>
    <script src="{{ asset('js/Admin/jquery.mask.js') }}" ></script>
    <script src="{{ asset('js/Admin/jquery.form.js') }}" ></script>
    <script src="{{ asset('js/Admin/forms.js') }}" ></script>
    
</head>
<body>
    <section id="main-content-login">
        @yield('content')
    </section>
</body>
</html>
