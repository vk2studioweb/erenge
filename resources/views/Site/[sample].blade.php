@extends('Site.layouts.app')
@section('metatags-share')
<meta name="keywords" content="{{$thisdata->config->keywords}}" />
<meta name="description" content="{{ strip_tags($thisdata->config->description, '') }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$thisdata->config->name}}" />
{{-- <meta property="og:image:alt" content="" />
<meta property="og:image" content="" /> --}}
<meta property="og:site_name" content="{{$thisdata->config->name}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.nameSite', $thisdata->config->name) }}</title>
@endsection
@section('content')
<div class="header-spacing"></div>
<section>
</section>
@endsection