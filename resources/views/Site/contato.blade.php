@extends('Site.layouts.app')

@section('metatags-share')
<title>Contato — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="Contato — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url('/contato') }}">
<link rel="canonical" href="{{ url('/contato') }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- FORMULÁRIO --}}
<section id="contatoForm" aria-label="Entre em Contato">
    <div class="box boxCollun" id="contatoFormWrap">

        <div id="contatoFormTitleWrap">
            <h1 id="contatoFormTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['contatoFormTitle'][0]->description ?? '', '<strong><br>') !!}
            </h1>
            <p id="contatoFormDesc" data-aos="fade-up" data-aos-duration="900">
                {!! strip_tags($thisdata->texts['contatoFormDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="contatoFormBox">
            {!! Form::open(['route' => 'contato.send', 'id' => 'formContato', 'autocomplete' => 'off']) !!}
            @csrf

            <div class="trabalheFormRow">
                <div class="trabalheFormField" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::text('nome', null, [
                        'class'       => 'trabalheFormInput',
                        'placeholder' => 'Seu Nome*',
                        'aria-label'  => 'Seu nome completo',
                        'required'
                    ]) !!}
                </div>
                <div class="trabalheFormField" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::email('email', null, [
                        'class'       => 'trabalheFormInput',
                        'placeholder' => 'Seu E-mail*',
                        'aria-label'  => 'Seu e-mail',
                        'required'
                    ]) !!}
                </div>
            </div>

            <div class="trabalheFormRow">
                <div class="trabalheFormField" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::text('telefone', null, [
                        'class'       => 'trabalheFormInput trabalheFormMaskPhone',
                        'placeholder' => 'Seu Telefone*',
                        'aria-label'  => 'Seu telefone',
                        'required'
                    ]) !!}
                </div>
                <div class="trabalheFormField" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::text('assunto', null, [
                        'class'       => 'trabalheFormInput',
                        'placeholder' => 'Assunto*',
                        'aria-label'  => 'Assunto da mensagem',
                        'required'
                    ]) !!}
                </div>
            </div>

            <div class="trabalheFormRow trabalheFormRowFull">
                <div class="trabalheFormField trabalheFormFieldFull" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::textarea('mensagem', null, [
                        'class'       => 'trabalheFormTextarea',
                        'placeholder' => 'Sua mensagem*',
                        'aria-label'  => 'Sua mensagem',
                        'rows'        => 6,
                        'required'
                    ]) !!}
                </div>
            </div>

            <div class="trabalheFormRow trabalheFormRowSubmit">
                <div id="contatoFormCaptcha">
                    {!! HCaptcha::display() !!}
                </div>
                <button type="submit"
                data-aos="fade-up" data-aos-duration="500"
                        id="contatoFormBtn"
                        aria-label="Enviar mensagem">
                    Enviar Mensagem
                </button>
            </div>

            {!! Form::close() !!}
        </div>

    </div>
</section>

{{-- OUTRAS FORMAS DE CONTATO --}}
@if(isset($thisdata->outrosContatos) && count($thisdata->outrosContatos) > 0)
<section id="outrosContatos" aria-label="Outras formas de Contato">
    <div class="box boxCollun" id="outrosContatosWrap">

        <div id="outrosContatosTitleWrap">
            <h2 id="outrosContatosTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['outrosContatosTitle'][0]->description ?? '<strong>Outras formas</strong> de Contato', '<strong><br>') !!}
            </h2>
            <p id="outrosContatosDesc" data-aos="fade-up" data-aos-duration="900">
                {!! strip_tags($thisdata->texts['outrosContatosDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="outrosContatosGrid">
            @foreach($thisdata->outrosContatos as $outro)
            @if(!empty($outro->link) && $outro->link != '')
            <a href="{{ $outro->link }}"
               class="outroContatoBtn"
               target="_blank"
               data-aos="fade-up" data-aos-duration="500"
               rel="noopener noreferrer"
               aria-label="Falar com {{ $outro->nome }} pelo WhatsApp">
                <i class="icon-erenge icon-whatsapp icon-whatsappOutroContato" aria-hidden="true"></i>
                {{ $outro->nome }}
            </a>
            @else
            <span class="outroContatoBtn" data-aos="fade-up" data-aos-duration="500">
                {{ $outro->telefone }}
                <strong>{{ $outro->nome }}</strong>
            </span>
            @endif
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- MAPA --}}
@include('Site.layouts.map')

@endsection
