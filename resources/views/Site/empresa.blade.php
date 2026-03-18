@extends('Site.layouts.app')

@section('metatags-share')
<title>Empresa — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="Empresa — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url('/empresa') }}">
<link rel="canonical" href="{{ url('/empresa') }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- NOSSA HISTÓRIA --}}
<section id="empresaHistoria" aria-label="Nossa História" itemscope itemtype="https://schema.org/Organization">
    <div class="box boxRow" id="empresaHistoriaContent">
        <div id="empresaHistoriaLeft" class="boxCollun">
            <h2 id="empresaHistoriaTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['empresaHistoriaTitle'][0]->description, '<strong><br>') !!}
            </h2>
            <div id="empresaHistoriaTexto" itemprop="description" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->textbusiness['empresaHistoriaTexto'][0]->description ?? '', '<strong><br><p>') !!}
            </div>
        </div>
        <div id="empresaHistoriaRight" data-aos="fade-up-left" data-aos-duration="500">
            @if(isset($thisdata->textbusiness['empresaHistoriaTexto'][0]->images))
            <img id="empresaHistoriaImg"
                 src="{{ $thisdata->textbusiness['empresaHistoriaTexto'][0]->images[0]->default ?? '' }}"
                 alt="Nossa História — Erenge Construções"
                 itemprop="image"
                 loading="eager"
                 decoding="async"
                 aria-label="Imagem Nossa História">
            @endif
        </div>
    </div>
</section>

{{-- MISSÃO / VISÃO / VALORES --}}
<section id="empresaMvv" aria-label="Missão, Visão e Valores">
    <div class="box boxRow" id="empresaMvvContent">

        <div class="empresaMvvCol" id="empresaMvvMissao">
            <h2 class="empresaMvvTitle" data-aos="fade-up" data-aos-duration="500">Missão</h2>
            <div class="empresaMvvTexto" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->textbusiness['empresaMissaoTexto'][0]->description ?? '', '<strong><br><p>') !!}
            </div>
        </div>

        <div class="empresaMvvCol" id="empresaMvvVisao">
            <h2 class="empresaMvvTitle" data-aos="fade-up" data-aos-duration="700">Visão</h2>
            <div class="empresaMvvTexto" data-aos="fade-up" data-aos-duration="700">
                {!! strip_tags($thisdata->textbusiness['empresaVisaoTexto'][0]->description ?? '', '<strong><br><p>') !!}
            </div>
        </div>

        <div class="empresaMvvCol" id="empresaMvvValores">
            <h2 class="empresaMvvTitle" data-aos="fade-up" data-aos-duration="800">Valores</h2>
            <div class="empresaMvvTexto empresaMvvValoresGrid" data-aos="fade-up" data-aos-duration="800">
                {!! strip_tags($thisdata->textbusiness['empresaValoresTexto'][0]->description ?? '', '<strong>') !!}
            </div>
        </div>

    </div>
</section>


{{-- MAPA --}}
@include('Site.layouts.map')

@endsection