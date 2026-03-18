@extends('Site.layouts.app')

@section('metatags-share')
<title>Obras — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="Obras — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url('/obras') }}">
<link rel="canonical" href="{{ url('/obras') }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- OBRAS EXECUTADAS --}}
<section id="obrasExecutadas" aria-label="Obras Executadas">
    <div class="box boxCollun">

        <div id="obrasExecutadasTitleWrap">
            <h1 id="obrasExecutadasTitleSection" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['tituloObras'][0]->description ?? '', '<strong><br>') !!}
            </h1>
            <p id="obrasExecutadasDesc" data-aos="fade-up" data-aos-duration="1000">
                {!! strip_tags($thisdata->texts['subtituloObras'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="obrasExecutadasGrid">
            @foreach($thisdata->obras as $obra)
            <article class="obraCard" itemscope itemtype="https://schema.org/CreativeWork">
                <a href="{{ route('obras.show', ['slug' => urlencode($obra->nome), 'id' => $obra->id_obra]) }}"
                   class="obraCardLink"
                   aria-label="Ver obra {{ $obra->nome }}">
                    <figure class="obraCardImgWrap" data-aos="fade-up-left" data-aos-duration="500">
                        <img class="lozad obraCardImg"
                             data-src="{{ $obra->images[0]->default ?? '' }}"
                             src="{{ $obra->images[0]->default ?? '' }}"
                             alt="{{ $obra->nome }}"
                             itemprop="image"
                             loading="lazy"
                             decoding="async">
                    </figure>
                    <div class="obraCardInfo">
                        <strong class="obraCardNome" itemprop="name" data-aos="fade-up" data-aos-duration="500">{{ $obra->nome }}</strong>
                        <span class="obraCardLocal" data-aos="fade-up" data-aos-duration="800">{{ $obra->local_obra }}</span>
                        <button class="obraCardButton" data-aos="fade-up-left" data-aos-duration="1000"
                                aria-label="Ver detalhes da obra {{ $obra->nome }}">Ver detalhes</button>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        {{-- PAGINAÇÃO --}}
        @if($thisdata->obras->lastPage() > 1)
        <nav data-aos="fade-up" data-aos-duration="500" id="obrasPagination" aria-label="Paginação de obras">
            {{ $thisdata->obras->links('vendor.pagination.erenge') }}
        </nav>
        @endif

    </div>
</section>

@endsection