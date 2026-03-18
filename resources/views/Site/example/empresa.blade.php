@extends('Site.layouts.app')
@section('metatags-share')
    <meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
    <meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }} " />
    {{-- <meta property="og:image:alt" content="" />
    <meta property="og:image" content="" /> --}}
    <meta property="og:site_name" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.nameSite', isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME')) }}</title>
@endsection
@section('content')
    <main id="main-website" class="main-bussinesshistory">
         <!-- Internal Banner -->
         @include('Site.layouts.internalbanner')
         <!-- END Internal Banner -->

         <div class="main">
            <section id="hystory">
                <div id="history-video">
                    @if(!$thisdata->video->isEmpty())
                    <iframe src="https://www.youtube.com/embed/2AxB5RtcIhU?si={{ $thisdata->video[0]->urlvideo }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @endif
                </div>
                <section id="main-history">
                    <h1 class="title-history">{{ $thisdata->textbusiness['empressahistoria'][0]->name }}</h1>
                    <article class="text-history">{!! strip_tags($thisdata->textbusiness['empressahistoria'][0]->description, '<p></p><br></br><b>') !!}</article>
                </section>
            </section>
         </div>
         <section id="institutional">
            <div class="main">
                <section id="main-visionAndMission">
                    <article id="main-mission" class="data-missionandvalue">
                        <h2 class="title-institutional">{{ $thisdata->textbusiness['empresamissao'][0]->name }}</h2>
                        {!! strip_tags($thisdata->textbusiness['empresamissao'][0]->description, '<p></p><br></br><b>') !!}
                    </article>
                    <article id="main-vision" class="data-missionandvalue">
                        <h2 class="title-institutional">{{ $thisdata->textbusiness['empresavisao'][0]->name }}</h2>
                        {!! strip_tags($thisdata->textbusiness['empresavisao'][0]->description, '<p></p><br></br><b>') !!}
                    </article>
                </section>
                <section id="main-values">
                    <h2 id="title-values" class="title-institutional">Valores</h2>
                    <ul id="list-values">
                        @foreach ($thisdata->values as $value)
                        <li class="item-values">
                            @if(!$value->images->isEmpty())
                            <div class="image-value positionImg"><img src="{{ $value->images[0]->default }}" alt="{{ $value->name }}"/></div>
                            @endif
                            <h3 class="name-value">{{ $value->name }}</h3>
                            <article class="desscription-value">{!! strip_tags($value->description, '<p></p><br></br><b>') !!}</article>
                        </li>
                        @endforeach
                    </ul>
                </section>
                <article id="main-institutional">{!! strip_tags($thisdata->textbusiness['empresainstitucional'][0]->description, '<p></p><br></br><b>') !!}</article>
            </div>
        </section>
         <div class="main">
            <section id="laboratory">
                @if(!$thisdata->textbusiness['empresalaboratorio'][0]->images->isEmpty())
                <div id="gallery-laboratory">
                    @foreach ($thisdata->textbusiness['empresalaboratorio'][0]->images as $key=>$image)
                        @if($key < 3)
                            <div class="image-laboratory positionImg"><img src="{{ $image->default }}" alt="Imagem {{ $key }} do laboratório"/></div>   
                        @endif                     
                    @endforeach
                </div>
                @endif
                <div id="date-laboratory">
                    <h2 id="title-laboratory">{{ $thisdata->textbusiness['empresalaboratorio'][0]->name }}</h2>
                    <article id="details-laboratory">{!! strip_tags($thisdata->textbusiness['empresalaboratorio'][0]->description, '<p></p><br></br><b>') !!}</article>
                </div>
            </section>
         </div>
         <section id="atuation">
            <div class="main">
                <section id="main-actuation">
                    @if(!$thisdata->textbusiness['empresaatuacao'][0]->images->isEmpty())
                    <div id="image-actuation" class="positionImg">
                        <img src="{{ $thisdata->textbusiness['empresaatuacao'][0]->images[0]->default }}" alt="{{ $thisdata->textbusiness['empresaatuacao'][0]->name }}"/>                        
                    </div>
                    @endif
                    <ul id="items-actuation">
                        <li class="item-actuation">
                            <h2 class="title-atuaction">{{ $thisdata->textbusiness['empresaatuacao'][0]->name }}</h2>
                            <article class="details-actuation">{!! strip_tags($thisdata->textbusiness['empresaatuacao'][0]->description, '<p></p><br></br><b>') !!}</article>
                        </li>
                        <li class="item-actuation">
                            <h2 class="title-atuaction">{{ $thisdata->textbusiness['empresasemeadura'][0]->name }}</h2>
                            <article class="details-actuation">{!! strip_tags($thisdata->textbusiness['empresasemeadura'][0]->description, '<p></p><br></br><b>') !!}</article>
                        </li>
                    </ul>
                </section>
            </div>      
         </section>
         <div class="main">
            <section id="certificates">
                <h2 class="title-certificates">{{ $thisdata->textbusiness['empresacertificacao'][0]->name }}</h2>
                <article class="details-certificates">{!! strip_tags($thisdata->textbusiness['empresacertificacao'][0]->description, '<p></p><br></br><b>') !!}</article>
                <section id="main-certificates">
                    <h2 class="subtitle-certificates">As sementes produzidas na Sementes Giovelli possuem:</h2>
                    <ul id="list-certificate">
                        @foreach ($thisdata->certificates as $certificate)
                            <li class="item-certificate">
                                @if(!$certificate->images->isEmpty())
                                <div id="image-certificate positionImg">
                                    <img src="{{ $certificate->images[0]->default }}" alt="{{ $certificate->name }}"/>                        
                                </div>
                                @endif
                                <div class="date-certificate">
                                    <h3 class="name-certificate">{{ $certificate->name }}</h3>
                                    <article class="detail-certificate">{!! strip_tags($certificate->description, '<p></p><br></br><b>') !!}</article>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </section>
            <section id="project">
                @if (!$thisdata->textbusiness['empresaprojeto'][0]->images->isEmpty())
                <div id="gallery-project">
                    <img class="logo-project" src="{{ $thisdata->textbusiness['empresaprojeto'][0]->images[0]->default }}" alt="{{ $thisdata->textbusiness['empresaprojeto'][0]->name }}"/>
                    @if ($thisdata->textbusiness['empresaprojeto'][0]->images->count() > 1)
                    <div class="image-project positionImg"><img class="logo-project" src="{{ $thisdata->textbusiness['empresaprojeto'][0]->images[1]->default }}" alt="Imagem do projeto: {{ $thisdata->textbusiness['empresaprojeto'][0]->name }}"/> </div>
                    @endif
                </div>
                @endif
                <section id="main-project">
                    <h2 class="title-project">{{ $thisdata->textbusiness['empresaprojeto'][0]->name }}</h2>
                    <article class="details-project">{!! strip_tags($thisdata->textbusiness['empresaprojeto'][0]->description, '<p></p><br></br><b>') !!}</article>
                </section>
            </section>
            <article id="quote">
                {!! strip_tags($thisdata->textbusiness['empresaprojetocitacao'][0]->description, '<p></p><br></br><b>') !!}
            </article>
         </div>
    </main>
@endsection
