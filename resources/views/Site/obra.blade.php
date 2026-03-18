@extends('Site.layouts.app')

@section('metatags-share')
<title>{{ $thisdata->obra->nome }} — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}</title>
<meta name="keywords" content="{{ isset($thisdata->config->keywords) ? $thisdata->config->keywords : '' }}" />
<meta name="description" content="{{ isset($thisdata->obra->descricao) ? strip_tags($thisdata->obra->descricao) : '' }}" />
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $thisdata->obra->nome }} — {{ isset($thisdata->config->name) ? $thisdata->config->name : env('APP_NAME') }}" />
<meta property="og:url" content="{{ url()->current() }}">
<link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

{{-- PAGE HERO --}}
@include('Site.layouts.hero')

{{-- DETALHE DA OBRA --}}
<section id="obraDetalhe" aria-label="{{ $thisdata->obra->nome }}" itemscope itemtype="https://schema.org/CreativeWork">
    <div class="box boxRow" id="obraDetalheContent">

        <div id="obraDetalheLeft" data-aos="fade-up" data-aos-duration="500">
            <img id="obraDetalheImg"
                 src="{{ $thisdata->obra->images[0]->default ?? '' }}"
                 alt="{{ $thisdata->obra->nome }}"
                 itemprop="image"
                 loading="eager"
                 decoding="async"
                 aria-label="Imagem principal {{ $thisdata->obra->nome }}">
        </div>

        <div id="obraDetalheRight" class="boxCollun">
            <h1 id="obraDetalheTitle" itemprop="name" data-aos="fade-up" data-aos-duration="500">{{ $thisdata->obra->nome }}</h1>
            <div id="obraDetalheTexto" itemprop="description" data-aos="fade-up" data-aos-duration="1000">
                {!! strip_tags($thisdata->obra->descricao ?? '', '<strong><br><p>') !!}
            </div>
        </div>

    </div>
</section>

{{-- INFORMAÇÕES DA OBRA --}}
<section id="obraInfo" aria-label="Informações da obra {{ $thisdata->obra->nome }}">
    <div class="box boxRow" id="obraInfoContent">

        {{-- Mapa --}}
        <div id="obraInfoMapa" aria-label="Mapa de localização da obra">
            <div id="obraInfoMapaLeaflet" data-coords="{{  $thisdata->obra->coordenada ?? ''}}"></div>
        </div>

        {{-- Dados técnicos --}}
        <div id="obraInfoDados" class="boxCollun">
            <h2 id="obraInfoDadosTitle" data-aos="fade-up" data-aos-duration="500">Informações desta Obra:</h2>

            @if(isset($thisdata->obra->local_obra))
            <p id="obraInfoLocal" data-aos="fade-up" data-aos-duration="1000">
                Local: <strong>{{ $thisdata->obra->local_obra }}</strong>
            </p>
            @endif

            @if(isset($thisdata->obra->detalhes) && $thisdata->obra->detalhes)
            <div id="obraInfoDetalhesGrid" data-aos="fade-up" data-aos-duration="800">
                {!! strip_tags($thisdata->obra->detalhes, '<ul><li><strong><br>') !!}
            </div>
            @endif
        </div>

    </div>
</section>

{{-- GALERIA --}}
@if(isset($thisdata->obra->images) && count($thisdata->obra->images) > 1)
<section id="obraGaleria" aria-label="Galeria de imagens {{ $thisdata->obra->nome }}">
    <div class="box boxCollun" id="obraGaleriaTitleWrap">
        <h2 id="obraGaleriaTitle" data-aos="fade-up" data-aos-duration="500">
            {!! strip_tags($thisdata->texts['obraGaleriaTitle'][0]->description ?? '', '<strong><br>') !!}
        </h2>
        <p id="obraGaleriaDesc" data-aos="fade-up" data-aos-duration="1000">
            {!! strip_tags($thisdata->texts['obraGaleriaDesc'][0]->description ?? '', '<strong><br>') !!}
        </p>
    </div>
    <div id="obraGaleriaGrid">
        @foreach($thisdata->obra->images as $key => $imagem)
        @if($key > 0)
        <a href="{{ $imagem->default ?? '' }}"
           class="obraGaleriaItem"
           data-lightbox="galeria-obra"
           data-title="{{ $thisdata->obra->nome }}"
           data-aos="fade-up" data-aos-duration="1500"
           aria-label="Ver imagem {{ $loop->iteration }} de {{ $thisdata->obra->nome }}">
            <img class="lozad obraGaleriaImg"
                 data-src="{{ $imagem->medium ?? '' }}"
                 src="{{ $imagem->medium ?? '' }}"
                 alt="{{ $thisdata->obra->nome }} — imagem {{ $loop->iteration }}"
                 loading="lazy"
                 decoding="async">
        </a>
        @endif
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section id="homeCta" aria-label="Fale com o comercial" itemscope itemtype="https://schema.org/ContactPage">
    <div class="box boxRow" id="homeCtaContent">
        <div id="homeCtaText">
            <h2 id="homeCtaTitle" data-aos="fade-up-left" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['homeCtaTitle'][0]->description ?? '', '<strong><br>') !!}
            </h2>
            <p id="homeCtaDesc" data-aos="fade-up-left" data-aos-duration="500">
                {!! strip_tags($thisdata->texts['homeCtaDesc'][0]->description ?? '', '<strong><br>') !!}
            </p>
        </div>
        <a href="{{ $thisdata->whatsapp->link ?? '' }}"
           id="homeCtaBtn"
           target="_blank"
           rel="noopener noreferrer"
           data-aos="fade-up-right" data-aos-duration="500"
           aria-label="Falar com o comercial pelo WhatsApp">
            <i class="icon-erenge icon-whatsapp icon-whatsappCta" aria-hidden="true"></i>
            Falar com o comercial
        </a>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(isset($thisdata->obra->coordenada) && $thisdata->obra->coordenada)
    var coords = "{{ $thisdata->obra->coordenada }}".split(',');
    var lat = parseFloat(coords[0]);
    var lng = parseFloat(coords[1]);

    var map = L.map('obraInfoMapaLeaflet', {
        center: [lat, lng],
        zoom: 15,
        scrollWheelZoom: false,
        zoomControl: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var icon = L.icon({
        iconUrl: '{{ url("images/marker.png") }}',
        iconSize: [36, 48],
        iconAnchor: [18, 48],
        popupAnchor: [0, -48]
    });

    L.marker([lat, lng], { icon: icon })
     .addTo(map)
     .bindPopup('<strong>{{ $thisdata->obra->nome }}</strong><br>{{ $thisdata->obra->local_obra }}')
     .openPopup();
    @endif

    // Lozad
    const observer = lozad('.lozad');
    observer.observe();
});
</script>
@endsection