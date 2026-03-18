@extends('Admin.Layouts.app')

@section('content')
<!-- Inclui identificação da pag. -->
@include('Admin.Layouts.identification')

<section class="main-content">
    
    <!-- Inclui html do alerta na página -->
    @include('Admin.Layouts.mainAlert')

    <!-- Inclui os botões de ação -->
    @include('Admin.Layouts.buttonsMenuStyleCollumn')

    <!-- Inclui a view com nome do model -->
    @include('Admin.Pages.'.$thisdata->pageConf->pageData->link)

</section>

@endsection