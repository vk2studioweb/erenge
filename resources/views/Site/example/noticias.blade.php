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

        <div id="main-news" class="main">
            <section id="page-title">
                <h1>Notícias</h1>
            </section>
            <ul id="list-news" class="list-newsInNews">
                @foreach ($thisdata->news as $news)
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
            {{ $thisdata->news->links() }}
    
    
        </div>

    </main>
@endsection
