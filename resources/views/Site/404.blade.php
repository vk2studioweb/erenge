@extends('Site.layouts.app')
@section('metatags-share')
<meta name="keywords" content="{{$thisdata->config->keywords}}" />
<meta name="description" content="{{ strip_tags($thisdata->config->description, '') }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$thisdata->config->name}}" />
{{-- <meta property="og:image:alt" content="" />
<meta property="og:image" content="" /> --}}
<meta property="og:site_name" content="{{$thisdata->config->name}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.nameSite', $thisdata->config->name) }}</title>
@endsection
@section('content')
        
    @include('Site.layouts.internalbanner')
    
    <section id="404-error" class="error-404">
        <div class="main main-404">            
            <h1 class="titulo-404">404</h1>
            <h2 class="subtitulo-404">{!! strip_tags(locale() == 'pt' ? $thisdata->texts['404'][0]->description : $thisdata->texts['404'][0]->description_en, '<p></p><br><b>') !!}</h2>
        </div>                
    </section>

    <section class="error-404-nav">
        <div class="main main-404">                                    
            <h2 class="titulo-acontecido">{!! strip_tags(locale() == 'pt' ? $thisdata->texts['404'][1]->description : $thisdata->texts['404'][1]->description_en, '<p></p><br><b>') !!}</h2>     
            <article class="menu-404">
                {!! strip_tags(locale() == 'pt' ? $thisdata->texts['404'][2]->description : $thisdata->texts['404'][2]->description_en, '<p></p><br><b>') !!}
            </article>
            <a class="voltar_home_404" href="{{ route(app()->getLocale() . '.home') }}" alt="Voltar a Página Inicial">
                {{ __('site.volta_home') }}
            </a>
        </div>        
    </section>
    
@endsection
