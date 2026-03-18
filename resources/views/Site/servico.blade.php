@extends('Site.layouts.app')

@section('metatags-share')
<title>{{ $thisdata->servico->nome }} — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->servico->descricao) ? strip_tags($thisdata->servico->descricao) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $thisdata->servico->nome }} — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url()->current() }}">
<link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- DETALHE DO SERVIÇO --}}
<section id="servicoDetalhe" aria-label="{{ $thisdata->servico->nome }}" itemscope itemtype="https://schema.org/Service">
    <div class="box boxRow" id="servicoDetalheContent">

        <div id="servicoDetalheLeft">
            <img id="servicoDetalheImg"
                 src="{{ $thisdata->servico->images[0]->default ?? '' }}"
                 alt="{{ $thisdata->servico->nome }}"
                 itemprop="image"
                 loading="eager"
                 decoding="async"
                 data-aos="fade-up-left" data-aos-duration="500"
                 aria-label="Imagem {{ $thisdata->servico->nome }}">
        </div>

        <div id="servicoDetalheRight" class="boxCollun">
            <h1 id="servicoDetalheTitle" itemprop="name" data-aos="fade-up" data-aos-duration="500">
                {{ $thisdata->servico->nome }}
            </h1>
            <div id="servicoDetalheTexto" itemprop="description" data-aos="fade-up" data-aos-duration="900">
                {!! strip_tags($thisdata->servico->descricao ?? '', '<strong><br><p>') !!}
            </div>
        </div>

    </div>
</section>

{{-- CTA --}}
<section id="homeCta" aria-label="Fale com o comercial" itemscope itemtype="https://schema.org/ContactPage">
    <div class="box boxRow" id="homeCtaContent">
        <div id="homeCtaText">
            <h2 id="homeCtaTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['homeCtaTitle'][0]->description ?? '', '<strong><br>') !!}
            </h2>
            <p id="homeCtaDesc" data-aos="fade-up" data-aos-duration="800">
                {!! strip_tags($thisdata->texts['homeCtaDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>
        <a href="{{ $thisdata->whatsapp->link ?? '' }}"
           id="homeCtaBtn"
           target="_blank"
           rel="noopener noreferrer"
           data-aos="fade-up-left" data-aos-duration="500"
           aria-label="Falar com o comercial pelo WhatsApp">
            <i class="icon-erenge icon-whatsapp icon-whatsappCta" aria-hidden="true"></i>
            Falar com o comercial
        </a>
    </div>
</section>

{{-- OBRAS DO SERVIÇO --}}
@if(isset($thisdata->obras) && count($thisdata->obras) > 0)
<section id="servicoObras" aria-label="Obras de {{ $thisdata->servico->nome }}">
    <div class="box boxCollun" id="servicoObrasTitleWrap">
        <h2 id="servicoObrasTitle" data-aos="fade-up" data-aos-duration="500">
            {!! strip_tags($thisdata->texts['servicoObrasTitle'][0]->description ?? '', '<strong><br>') !!}
        </h2>
    </div>
    <div class="box boxRow" id="obrasExecutadasGrid">
        @foreach($thisdata->obras as $obra)
            <article class="obraCard" itemscope itemtype="https://schema.org/CreativeWork">
                <a href="{{ route('obras.show', ['slug'=>urlencode($obra->nome), 'id'=>$obra->id_obra]) }}"
                class="obraCardLink"
                aria-label="Ver obra {{ $obra->nome }}">
                    <figure class="obraCardImgWrap" data-aos="fade-up" data-aos-duration="900">
                        <img class="obraCardImg"
                            data-src="{{ $obra->images[0]->default ?? '' }}"
                            src="{{ $obra->images[0]->default ?? '' }}"
                            alt="{{ $obra->nome }}"
                            itemprop="image"
                            loading="lazy"
                            decoding="async">
                    </figure>
                    <div class="obraCardInfo">
                        <strong class="obraCardNome" itemprop="name" data-aos="fade-up-left" data-aos-duration="500">{{ $obra->nome }}</strong>
                        <span class="obraCardLocal" data-aos="fade-up-left" data-aos-duration="800">{{ $obra->local_obra }}</span>
                        <button
                        class="obraCardButton"
                        data-aos="fade-up" data-aos-duration="1000"
                        aria-label="Ver detalhes da obra {{ $obra->nome }}">Ver detalhes</button>
                    </div>
                </a>
            </article>
        @endforeach
    </div>
</section>
@endif

@endsection