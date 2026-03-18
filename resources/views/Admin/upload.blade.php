@extends('Admin.Layouts.app')

@section('content')

    <section id="main-identification-page">
        <h3 class="title-page-identification">Página(s)</h3>
        @if($thisdata->pageConf->pageFather !== 'null')
        <a class="link-identificate-page" href="{{ url('/admin/'.$thisdata->pageConf->pageFather) }}">{{ $thisdata->pageConf->pageFather }}</a>
        <hr/>
        @endif
        <h2 class="page-select-identification">UPLOAD</h2>
    </section>
<section class="main-content">

    <!-- Inclui html do alerta na página -->
    @include('Admin.Layouts.mainAlert')

    <!-- Inclui html do alerta na página -->
    @include('Admin.Layouts.buttonUpload')

    <!-- Inclui a view com nome do model -->
    @include('Admin.Pages.upload')

</section>

@endsection