@extends('Site.layouts.app')

@section('metatags-share')
<title>Trabalhe Conosco — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="Trabalhe Conosco — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url('/trabalhe-conosco') }}">
<link rel="canonical" href="{{ url('/trabalhe-conosco') }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- FORMULÁRIO --}}
<section id="trabalheForm" aria-label="Envie seu Currículo">
    <div class="box boxCollun" id="trabalheFormWrap">

        <div id="trabalheFormTitleWrap">
            <h1 id="trabalheFormTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['trabalheFormTitle'][0]->description ?? '') !!}
            </h1>
            <p id="trabalheFormDesc" data-aos="fade-up" data-aos-duration="1000">
                {!! strip_tags($thisdata->texts['trabalheFormDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="trabalheFormBox">
            {!! Form::open(['route' => 'trabalheConosco.send', 'id' => 'formTrabalhe', 'files' => true, 'autocomplete' => 'off']) !!}
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
                <div class="trabalheFormField" data-aos="fade-up" data-aos-duration="800">
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
                <div class="trabalheFormField" data-aos="fade-up" data-aos-duration="800">
                    {!! Form::text('cidade', null, [
                        'class'       => 'trabalheFormInput',
                        'placeholder' => 'Cidade*',
                        'aria-label'  => 'Sua cidade',
                        'required'
                    ]) !!}
                </div>
            </div>

            <div class="trabalheFormRow">
                <div class="trabalheFormField trabalheFormFieldFile" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::file('curriculo', [
                        'class'      => 'trabalheFormInputFile',
                        'id'         => 'inputCurriculo',
                        'accept'     => '.pdf,.doc,.docx',
                        'aria-label' => 'Anexar currículo',
                        'required'
                    ]) !!}
                    <label for="inputCurriculo" class="trabalheFormFileLabel" aria-label="Selecionar currículo">
                        <span class="trabalheFormFileName" id="nomeCurriculo">Seu Currículo*</span>
                    </label>
                    <span class="trabalheFormFileInfo">Anexo em .pdf, .doc, .docx — Arquivo de 25mb</span>
                </div>
                <div class="trabalheFormField trabalheFormFieldFile" data-aos="fade-up" data-aos-duration="800">
                    {!! Form::file('carteira', [
                        'class'      => 'trabalheFormInputFile',
                        'id'         => 'inputCarteira',
                        'accept'     => '.pdf',
                        'aria-label' => 'Anexar carteira digital'
                    ]) !!}
                    <label for="inputCarteira" class="trabalheFormFileLabel" aria-label="Selecionar carteira digital">
                        <span class="trabalheFormFileName" id="nomeCarteira">Carteira Digital</span>
                    </label>
                    <span class="trabalheFormFileInfo">Exporte o PDF "Carteira de Trabalho Digital" — Arquivo de 25mb</span>
                </div>
            </div>

            <div class="trabalheFormRow trabalheFormRowFull">
                <div class="trabalheFormField trabalheFormFieldFull" data-aos="fade-up" data-aos-duration="500">
                    {!! Form::textarea('mensagem', null, [
                        'class'       => 'trabalheFormTextarea',
                        'placeholder' => 'Informe mais detalhes da sua necessidade',
                        'aria-label'  => 'Mensagem adicional',
                        'rows'        => 6
                    ]) !!}
                </div>
            </div>

            <div class="trabalheFormRow trabalheFormRowSubmit">
                <div id="trabalheFormCaptcha" data-aos="fade-up" data-aos-duration="500">
                    {!! HCaptcha::display() !!}
                </div>
                <button type="submit"
                        id="trabalheFormBtn"
                        data-aos="fade-up" data-aos-duration="500"
                        aria-label="Enviar candidatura">
                    Enviar Candidatura
                </button>
            </div>

            {!! Form::close() !!}
        </div>

    </div>
</section>

{{-- BENEFÍCIOS --}}
@if(isset($thisdata->beneficios) && count($thisdata->beneficios) > 0)
<section id="trabalheBeneficios" aria-label="Nossos Benefícios e Programas">
    <div class="box boxCollun" id="trabalheBeneficiosWrap">

        <div id="trabalheBeneficiosTitleWrap">
            <h2 id="trabalheBeneficiosTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['trabalheBeneficiosTitle'][0]->description ?? '', '<strong><br>') !!}
            </h2>
            <p id="trabalheBeneficiosDesc" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['trabalheBeneficiosDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="trabalheBeneficiosGrid">
            @foreach($thisdata->beneficios as $beneficio)
            <article class="beneficioCard" itemscope itemtype="https://schema.org/Offer">
                <figure class="beneficioCardImgWrap" data-aos="fade-up" data-aos-duration="500">
                    <img class="lozad beneficioCardImg"
                         data-src="{{ $beneficio->images[0]->medium ?? '' }}"
                         src="{{ $beneficio->images[0]->medium ?? '' }}"
                         alt="{{ $beneficio->nome }}"
                         itemprop="image"
                         loading="lazy"
                         decoding="async">
                </figure>
                <div class="beneficioCardInfo">
                    <strong class="beneficioCardNome" itemprop="name" data-aos="fade-up" data-aos-duration="500">{{ $beneficio->nome }}</strong>
                    <p class="beneficioCardDesc" itemprop="description" data-aos="fade-up" data-aos-duration="900">
                        {!! strip_tags($beneficio->descricao ?? '', '<strong><br>') !!}
                    </p>
                </div>
            </article>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection
