@extends('Site.layouts.app')

@section('metatags-share')
<title>{{ $thisdata->noticia->nome }} — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->noticia->abreviacao) ? strip_tags($thisdata->noticia->abreviacao) : strip_tags($thisdata->noticia->descricao) }}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $thisdata->noticia->nome }} — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:description" content="{{ isset($thisdata->noticia->abreviacao) ? strip_tags($thisdata->noticia->abreviacao) : '' }}" />
<meta property="og:image" content="{{ $thisdata->noticia->images[0]->default ?? '' }}">
<meta property="og:url" content="{{ url()->current() }}">
<link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- DETALHE DA NOTÍCIA --}}
<section id="noticiaDetalhe" aria-label="{{ $thisdata->noticia->nome }}" itemscope itemtype="https://schema.org/NewsArticle">

    <div class="box boxCollun" id="noticiaDetalheWrap">

        {{-- Imagem principal --}}
        @if(isset($thisdata->noticia->images[0]))
        <figure id="noticiaDetalheImgWrap" data-aos="fade-up" data-aos-duration="500">
            <img id="noticiaDetalheImg"
                 src="{{ $thisdata->noticia->images[0]->banner ?? $thisdata->noticia->images[0]->default ?? '' }}"
                 alt="{{ $thisdata->noticia->nome }}"
                 itemprop="image"
                 loading="eager"
                 decoding="async"
                 aria-label="Imagem {{ $thisdata->noticia->nome }}">
        </figure>
        @endif

        {{-- Título e meta --}}
        <div id="noticiaDetalheTitleWrap">
            <h1 id="noticiaDetalheTitle" itemprop="headline" data-aos="fade-up" data-aos-duration="500">
                {{ $thisdata->noticia->nome }}
            </h1>
            <div id="noticiaDetalheMeta">
                @if(isset($thisdata->noticia->autor) && $thisdata->noticia->autor)
                <span class="noticiaDetalheMetaItem" itemprop="author" data-aos="fade-up" data-aos-duration="500">
                    Criado por: {{ $thisdata->noticia->autor }}
                </span>
                @endif
                @if(isset($thisdata->noticia->direitos) && $thisdata->noticia->direitos)
                <span class="noticiaDetalheMetaItem" data-aos="fade-up" data-aos-duration="800">
                    Direitos: {{ $thisdata->noticia->direitos }}
                </span>
                @endif
                <span class="noticiaDetalheMetaItem" itemprop="datePublished" content="{{ $thisdata->noticia->created_at }}" data-aos="fade-up" data-aos-duration="1000">
                    Criado em: {{ \Carbon\Carbon::parse($thisdata->noticia->created_at)->format('d/m/Y') }}
                </span>
            </div>
            <span id="noticiaDetalheLine" aria-hidden="true"></span>
        </div>

        {{-- Texto --}}
        <article id="noticiaDetalheTexto" itemprop="articleBody" data-aos="fade-up" data-aos-duration="500">
            {!! strip_tags($thisdata->noticia->descricao ?? '', '<strong><br><p><em><ul><li><ol><h2><h3>') !!}
        </article>

    </div>

</section>

{{-- MAIS NOVIDADES --}}
@if(isset($thisdata->maisNoticias) && count($thisdata->maisNoticias) > 0)
<section id="maisNovidades" aria-label="Mais Novidades">
    <div class="box boxCollun" id="maisNovidadesWrap">

        <div id="maisNovidadesTitleWrap">
            <h2 id="maisNovidadesTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['maisNovidadesTitle'][0]->description ?? '', '<strong><br>') !!}
            </h2>
        </div>

        <div id="novidadesGrid">
            @foreach($thisdata->maisNoticias as $noticia)
            <article class="noticiaCard" itemscope itemtype="https://schema.org/NewsArticle">
                <a href="{{ route('noticias.show', ['slug' => urlencode($noticia->nome), 'id' => $noticia->id_noticia]) }}"
                   class="noticiaCardLink"
                   aria-label="Ler notícia {{ $noticia->nome }}">
                    <figure class="noticiaCardImgWrap" data-aos="fade-up" data-aos-duration="500">
                        <img class="lozad noticiaCardImg"
                             data-src="{{ $noticia->images[0]->default ?? '' }}"
                             src="{{ $noticia->images[0]->default ?? '' }}"
                             alt="{{ $noticia->nome }}"
                             itemprop="image"
                             loading="lazy"
                             decoding="async">
                    </figure>
                    <div class="noticiaCardInfo">
                        <strong class="noticiaCardTitulo" itemprop="headline" data-aos="fade-up" data-aos-duration="800">{{ $noticia->nome }}</strong>
                        <button class="noticiaCardButton"
                                aria-label="Ler completo: {{ $noticia->nome }}" data-aos="fade-up" data-aos-duration="1000">Ler Completa</button>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection