@extends('Admin.Layouts.resetpassword')


@section('content')

<div class="title-admin">
    <h1>PAINEL <strong>ADMINISTRATIVO</strong></h1>
    <img src="{{ url('files/admin/images/logo_developer.png') }}" alt="Vk2 Studio WEB" title="Vk2 Studio WEB" />
</div>

<div class="container">
    <h2>Recuperar Senha</h2>
    {{-- Abrir formulário --}}
    {{ Form::open(['method' => 'post', 'url' => route('password.email'), 'onsubmit' => 'return false', 'id' => 'sendPasswordReset']) }}
    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label text-md-right">Endereço de E-mail</label>
        <div class="col-md-6">
            <input id="email" type="email" class="form-control" name="email" placeholder="Seu e-mail" required autofocus>
        </div>
    </div>

    <div class="form-group row">
        <label for="type" class="col-md-4 col-form-label text-md-right">
            Tipo de Conta
        </label>
        <div class="col-md-6">
            <select type="text" class="form-control" name="type" id="type" required autocomplete="off">
                <option value="" disabled selected hidden >Selecione um tipo de conta</option>
                <option value="1">Admin</option>
                <option value="2">Agendamento</option>
                <option value="3">Balança</option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                SOLICITAR NOVA SENHA
            </button>
            <a class="btn btn-link" href="{{ route('login') }}">
                Voltar para login
            </a>
        </div>
    </div>
    {{-- Fechar formulário --}}
    {{ Form::close() }}
    </form>

</div>
@endsection