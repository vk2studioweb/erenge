@extends('Site.layouts.app')

@section('metatags-share')
<title>Serviços — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->config->description) ? strip_tags($thisdata->config->description) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="Serviços — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url('/servicos') }}">
<link rel="canonical" href="{{ url('/servicos') }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- SERVIÇOS PRESTADOS --}}
<section id="servicosPrestados" aria-label="Serviços Prestados">
    <div class="box boxCollun" id="servicosPrestadosWrap">

        <div id="servicosPrestadosTitleWrap">
            <h1 id="servicosPrestadosTitle" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['servicosPrestadosTitle'][0]->description ?? '', '<strong><br>') !!}
            </h1>
            <p id="servicosPrestadosDesc" data-aos="fade-up" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['servicosPrestadosDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>

        <div id="servicosGrid">
            @foreach($thisdata->servicos as $key=>$servico)
            <article class="servicoCard" itemscope itemtype="https://schema.org/Service" data-aos="fade-up-left" data-aos-duration="{{ $key * 100 }}">
                <a href="{{ route('servicos.show', ['slug' => urlencode($servico->nome), 'id' => $servico->id_servico]) }}"
                   class="servicoCardLink"
                   aria-label="Ver detalhes do serviço {{ $servico->nome }}">
                    <figure class="servicoCardImgWrap">
                        <img class="lozad servicoCardImg"
                             data-src="{{ $servico->images[0]->default ?? '' }}"
                             src="{{ $servico->images[0]->default ?? '' }}"
                             alt="{{ $servico->nome }}"
                             itemprop="image"
                             loading="lazy"
                             decoding="async">
                        <div class="servicoCardOverlay">
                            <button class="servicoCardBtn" aria-label="Ver detalhes de {{ $servico->nome }}">
                                Ver detalhes
                            </button>
                        </div>
                    </figure>
                    <div class="servicoCardInfo">
                        <strong class="servicoCardNome" itemprop="name">{{ $servico->nome }}</strong>
                        <p class="servicoCardDesc" itemprop="description">{!! str_limit(strip_tags($servico->descricao , '<strong><br>'), 234) !!}</p>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

    </div>
</section>

@endsection