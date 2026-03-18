@extends('Admin.Layouts.resetpassword')

@section('content')
    <div class="title-admin">
        <h1>PAINEL <strong>ADMINISTRATIVO</strong></h1>
        <img src="{{ url('files/admin/images/logo_developer.png') }}" alt="Vk2 Studio WEB" title="Vk2 Studio WEB" />
    </div>

    <div class="container">
        <h2>Alteração de senha</h2>
        
        <div class="card-body">
            {{-- Abrir formulário --}}
            {{ Form::open(['method' => 'post', 'url' => route('password.update', ['token' => $token]), 'onsubmit' => 'return false', 'id' => 'passwordReset']) }}
            @csrf

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nova senha') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm"
                    class="col-md-4 col-form-label text-md-right">{{ __('Confirmar nova senha') }}</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Salvar nova senha') }}
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
