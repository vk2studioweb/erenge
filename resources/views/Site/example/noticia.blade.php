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
    <main id="main-website">
        <!-- Internal Banner -->
        @include('Site.layouts.internalbanner')
        <!-- END Internal Banner -->
        
        <div class="main">
            <section id="news-select">
                <span class="date-newsSelect">{{ $thisdata->news->printdate }}</span>
                <h1 class="title-newsSelect">{{ $thisdata->news->name }}</h1>
                <article class="description-newsSelect">
                    @if(!$thisdata->news->images->isEmpty())
                    <div class="positionImg image-selectNews">
                        <img src="{{$thisdata->news->images[0]->default ?? 'images/default.webp' }}" alt="{{ $thisdata->news->name }}" />
                    </div>
                    @endif
                    {!! $thisdata->news->description !!}
                </article>
                @if(!$thisdata->news->images->isEmpty())
                <section id="gallery-news">
                    @foreach ($thisdata->news->images as $key=>$image)
                    @if($key > 0)
                    <a href="{{ $image->default }}" data-lightbox="news" class="positionImg image-galleryNews">
                        <img src="{{ $image->thumb380x380 ?? 'images/default.webp' }}" alt="Imagem {{ $key }} da notícia {{ $thisdata->news->name }}" />
                    </a>
                    @endif
                    @endforeach
                </section>
                @endif
            </section>

            <section id="other-news">
                <h2 class="title-otherNews">OUTRAS NOTÍCIAS</h2>
                <ul id="list-news" class="list-newsInNews">
                    @foreach ($thisdata->newsOther as $news)
                    <li class="item-news">
                        <a href="{{ route('noticia', ['name' => urlencode($news->name), 'id' => $news->id_news]) }}" title="{{ $news->name }}">
                            <article class="detail-itemNews">
                                <div class="positionImg image-itemNews">
                                    <img src="{{ $news->images[0]->thumb380x380 ?? 'images/default.webp' }}" alt="{{ $news->name }}" />
                                </div>
                                <h3 class="title-itemNews">{{ $news->name }}</h3>
                                {!! str_limit(strip_tags($news->description, '<p></p><br><b>'), 180) !!}
                                <button class="button-itemNews">LER MAIS</button>
                            </article>
                        </a>
                    </li>    
                    @endforeach
                </ul>
            </section>
        </div>
    </main>
@endsection
