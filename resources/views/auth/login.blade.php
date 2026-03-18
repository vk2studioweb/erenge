@extends('Admin.Layouts.login')

@section('content')

<div class="title-admin">
    <h1>PAINEL <strong>ADMINISTRATIVO</strong></h1>
    <img src="{{ url('files/admin/images/logo_developer.png') }}" alt="Vk2 Studio WEB" title="Vk2 Studio WEB" />
</div>

<div class="container">
    <h2>{{ __('Login') }}</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
                        
        @if ($errors->has('notauthorized'))
            <span class="invalid-user">
                {{ __('Usuário não permitido. Entre em contato com o administrador!') }}
            </span>
        @endif

        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Insira seu e-mail*') }}</label>
                               
            <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  placeholder="Seu e-mail" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Insira sua senha*') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Sua senha" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('LOGIN') }}
                </button>

                <a class="btn btn-link" href="{{route('password.request')}}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            </div>
        </div>
    </form>
</div>

@endsection
