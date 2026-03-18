@extends('Site.layouts.app')
@section('metatags-share')
    <meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
    <meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }} " />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="{!! strip_tags($thisdata->config->description) ?? '' !!}" />
    <meta property="og:image" content="{{ url('images/dindododudu.jpg') }}" />
    <meta property="og:site_name" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.nameSite', isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME')) }}</title>
@endsection
@section('content')
   {{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- NOVIDADES --}}
<section id="noticiasLista" aria-label="Novidades">
    <div class="box boxCollun" id="noticiaDetalheWrap">

        {{-- Título e meta --}}
        <div id="noticiaDetalheTitleWrap">
            <h1 id="noticiaDetalheTitle" itemprop="headline" data-aos="fade-up" data-aos-duration="500">
                {{ $thisdata->terms[0]->name }}
            </h1>
            <div id="noticiaDetalheMeta">
                <span class="noticiaDetalheMetaItem" itemprop="datePublished" content="{{ $thisdata->terms[0]->updated_at }}" data-aos="fade-up" data-aos-duration="1000">
                    Atualizado em: {{ \Carbon\Carbon::parse($thisdata->terms[0]->updated_at)->format('d/m/Y') }}
                </span>
            </div>
            <span id="noticiaDetalheLine" aria-hidden="true"></span>
        </div>

        {{-- Texto --}}
        <article id="noticiaDetalheTexto" itemprop="articleBody" data-aos="fade-up" data-aos-duration="500">
            {!! strip_tags($thisdata->terms[0]->description ?? '', '<strong><br><p><em><ul><li><ol><h2><h3>') !!}
        </article>
    </div>
</section>
@endsection
