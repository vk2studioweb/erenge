@extends('Admin.Layouts.app')

@section('content')
<!-- Inclui identificação da pag. -->
@include('Admin.Layouts.identification')

<section class="main-content">
    
    <!-- Inclui a view com nome do model -->
    @include('Admin.Pages.'.$thisdata->pageConf->pageData->link)

</section>

@endsection