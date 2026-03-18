@extends('Site.layouts.app')

@section('metatags-share')
<title>Novidades — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="Novidades — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url('/noticias') }}">
<link rel="canonical" href="{{ url('/noticias') }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- NOVIDADES --}}
<section id="noticiasLista" aria-label="Novidades">
    <div class="box boxCollun" id="noticiasListaWrap">

        <div id="noticiasListaTitleWrap">
            <h1 id="noticiasListaTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['tituloNovidades'][0]->description ?? '', '<strong><br>') !!}
            </h1>
            <p id="noticiasListaDesc" data-aos="fade-up" data-aos-duration="900">
                {!! strip_tags($thisdata->texts['noticiasListaDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="novidadesGrid">
            @foreach($thisdata->noticias as $key=>$noticia)
            <article class="noticiaCard" itemscope itemtype="https://schema.org/NewsArticle" data-aos="fade-up" data-aos-duration="{{ $key * 300 }}">
                <a href="{{ route('noticias.show', ['slug' => urlencode($noticia->nome), 'id' => $noticia->id_noticia]) }}"
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
                        <button class="noticiaCardButton"
                                aria-label="Ler completo: {{ $noticia->nome }}">Ler Completa</button>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        {{-- PAGINAÇÃO --}}
        @if($thisdata->noticias->lastPage() > 1)
        <nav id="obrasPagination" aria-label="Paginação de novidades" data-aos="fade-up" data-aos-duration="500">
            {{ $thisdata->noticias->links() }}
        </nav>
        @endif

    </div>
</section>

@endsection