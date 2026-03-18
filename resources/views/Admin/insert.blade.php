@extends('Admin.Layouts.app')

@section('content')

<!-- Inclui identificação da pag. -->
@include('Admin.Layouts.identification')

<section class="main-content">
    <div id='main-alert'>
        <div class='main-background-alert'></div>
        <div id='main-message-alert'>
            <hr class='button-alert button-alert-load ui-admin-circles-loader' />
            <span class='title-status-alert'>Processando</span>
            <p class='message-status-alert'>Aguarde enquanto efetuamos a operação</p>
            <span class="setFechamentoAutomatico">fechamento automatizado em: <strong></strong></span>
            <span class="button-close-alert">Fechar Notificação</span>
        </div>
    </div>
    <!-- Inclui os botões de ação -->
    @include('Admin.Layouts.buttonsInsert')

    <!-- Inclui a view com nome do model -->
    @include('Admin.Pages.'.$thisdata->pageConf->pageData->link)

</section>

@endsection