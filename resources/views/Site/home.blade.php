@extends('Site.layouts.app')

@section('metatags-share')
<title>{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />

<meta property="og:type" content="website">
<meta property="og:title" content="{{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:description" content="{!! strip_tags($thisdata->config->description) ?? '' !!}" />
<meta property="og:url" content="{{ url('/') }}">
@endsection

@section('content')

{{-- BANNER --}}
<section id="banner" aria-label="Banner principal">
    <div id="bannerSlider">
        @foreach($thisdata->banners as $banner)
        <div class="bannerItem" itemscope itemtype="https://schema.org/ImageObject">
            <a href="{{ route('servicos') }}"
                       class="bannerLnk"
                       aria-label="Conheça nossos serviços">
                <picture class="bannerImage">
                    <source media="(min-width: 801px)"  srcset="{{ $banner->images[0]->default ?? '' }}"  type="image/webp">
                    <source media="(max-width: 800px)"  srcset="{{ $banner->images[1]->default ?? '' }}"   type="image/webp">
                    <img class="bannerImageImg" src="{{ $banner->images[0]->default ?? '' }}" alt="{{ $banner->name }}" itemprop="contentUrl" decoding="async" aria-label="{{ $banner->name }}">
                </picture>
                <div class="bannerOverlay"></div>
                <div class="bannerContentWrap">
                    <div class="bannerContent">
                        <button
                        class="bannerBtn"
                        aria-label="Conheça nossos serviços">
                            <span>conheça</span>
                            <i class="icon-erenge icon-circleArrowRight icon-arrowBanner" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>

{{-- O QUE FAZEMOS --}}
<section id="oQueFazemos" aria-label="O que fazemos" itemscope itemtype="https://schema.org/Service">
    <div class="box boxCollun">
        <div id="oQueFazemosTitleWrap">
            <h2 id="oQueFazemosTitleSection" data-aos="fade-up" data-aos-duration="50">
                {!!  strip_tags($thisdata->texts['tituloOQueFazemos'][0]->description, '<strong><br>') !!}
            </h2>
        </div>
        <div id="oQueFazemosContent">

            {{-- Coluna Esquerda: lista de serviços --}}
            <ul id="oQueFazemosLeft">
                @foreach($thisdata->servicos as $key=>$servico)
                <li class="oQueFazemosServico {{ $key == 0 ? 'oQueFazemosServicoActive' : '' }}"
                    data-img="{{ $servico->images[0]->default ?? '' }}"
                    data-nome="{{ $servico->nome }}"
                    data-aos="fade-up-right" data-aos-duration="{{ $key * 100 }}">

                    <a href="{{ route('servicos.show', ['slug'=>urlencode($servico->nome), 'id'=>$servico->id_servico]) }}"
                    class="oQueFazemosServicoTitleLink"
                    aria-label="Ver serviço {{ $servico->nome }}">
                        <h3 class="oQueFazemosServicoTitle">{{ $servico->nome }}</h3>
                        <hr class="oQueFazemosServicoLine"/>
                        <button class="oQueFazemosVerMais"
                        aria-label="Ver mais sobre {{ $servico->nome }}">Ver mais</button>
                    </a>

                </li>
                @endforeach
            </ul>

            {{-- Coluna Direita: imagem --}}
            <div id="oQueFazemosRight">
                <img id="oQueFazemosImg"
                    src="{{ $thisdata->servicos[0]->images[0]->default ?? '' }}"
                    alt="{{ $thisdata->servicos[0]->nome ?? '' }}"
                    loading="lazy"
                    decoding="async"
                    aria-label="Imagem do serviço {{ $thisdata->servicos[0]->nome ?? '' }}"
                    data-aos="fade-up-left" data-aos-duration="500">
            </div>
        </div>
    </div>
</section>

{{-- OBRAS EXECUTADAS --}}
<section id="obrasExecutadas" aria-label="Obras executadas">
    <div class="box boxCollun">
        <div id="obrasExecutadasTitleWrap">
            <h2 id="obrasExecutadasTitleSection" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['tituloObras'][0]->description ?? '', '<strong><br>') !!}
            </h2>
            <p id="obrasExecutadasDesc" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['subtituloObras'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>
        <div id="obrasExecutadasGrid">
            @foreach($thisdata->obras as $key=>$obra)
            <article class="obraCard" itemscope itemtype="https://schema.org/CreativeWork" data-aos="fade-up-right" data-aos-duration="{{ $key * 300 }}">
                <a href="{{ route('obras.show', ['slug'=>urlencode($obra->nome), 'id'=>$obra->id_obra]) }}"
                class="obraCardLink"
                aria-label="Ver obra {{ $obra->nome }}">
                    <figure class="obraCardImgWrap">
                        <img class="lozad obraCardImg"
                            data-src="{{ $obra->images[0]->default ?? '' }}"
                            src="{{ $obra->images[0]->default ?? '' }}"
                            alt="{{ $obra->nome }}"
                            itemprop="image"
                            loading="lazy"
                            decoding="async">
                    </figure>
                    <div class="obraCardInfo">
                        <strong class="obraCardNome" itemprop="name">{{ $obra->nome }}</strong>
                        <span class="obraCardLocal">{{ $obra->local_obra }}</span>
                        <button
                        class="obraCardButton"
                        aria-label="Ver detalhes da obra {{ $obra->nome }}">Ver detalhes</button>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- NOVIDADES --}}
<section id="novidades" aria-label="Novidades">
    <div class="box boxCollun">
        <div id="novidadesTitleWrap">
            <h2 id="novidadesTitleSection" data-aos="fade-up" data-aos-duration="500">{!! strip_tags($thisdata->texts['tituloNovidades'][0]->description ?? '', '<strong><br>') !!}</h2>
        </div>
        <div id="novidadesGrid">
            @foreach($thisdata->noticias as $key=>$noticia)
            <article class="noticiaCard" itemscope itemtype="https://schema.org/NewsArticle" data-aos="fade-up" data-aos-duration="{{ $key * 500 }}">
                <a href="{{ route('noticias.show', ['slug'=>urlencode($noticia->nome), 'id'=>$noticia->id_noticia]) }}"
                class="noticiaCardLink"
                aria-label="Ler notícia {{ $noticia->nome }}">
                    <figure class="noticiaCardImgWrap">
                        <img class="lozad noticiaCardImg"
                        data-src="{{ $noticia->images[0]->default ?? '' }}"
                        src="{{ $noticia->images[0]->default ?? '' }}"
                        alt="{{ $noticia->nome }}"
                        itemprop="image"
                        loading="lazy"
                        decoding="async">
                    </figure>
                    <div class="noticiaCardInfo">
                        <strong class="noticiaCardTitulo" itemprop="headline">{{ $noticia->nome }}</strong>
                        <button
                        class="noticiaCardButton"
                        aria-label="Ler completo: {{ $noticia->nome }}">Ler Completa</button>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section id="homeCta" aria-label="Fale com o comercial" itemscope itemtype="https://schema.org/ContactPage">
    <div class="box boxRow" id="homeCtaContent">
        <div id="homeCtaText">
            <h2 id="homeCtaTitle" data-aos="fade-up-left" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['homeCtaTitle'][0]->description, '<strong><br>') !!}
            </h2>
            <p id="homeCtaDesc" data-aos="fade-up-left" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['homeCtaDesc'][0]->description, '<strong><br>') !!}
            </p>
        </div>
        <a href="{{ $thisdata->whatsapp->link ?? '' }}"
           id="homeCtaBtn"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Falar com o comercial pelo WhatsApp"
           data-aos="fade-up-right" data-aos-duration="500">
            <i class="icon-erenge icon-whatsapp icon-whatsappCta" aria-hidden="true"></i>
            Falar com o comercial
        </a>
    </div>
</section>

@endsection