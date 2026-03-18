
@extends('Admin.Layouts.app')

@section('content')
    
    <!-- Inclui identificação da pag. -->
    @include('Admin.Layouts.identification')
    
    <section class="main-content">
        
        <!-- Inclui html do alerta na página -->
        @include('Admin.Layouts.mainAlert')

        <!-- Inclui os botões de ações Permitidos para o usuário -->
        @include('Admin.Layouts.listButtons')
        
        <!-- Inclui busca e paginação -->
        @include('Admin.Layouts.listSearch')
        
        <!-- Inclui a listagem preferida para o layout usuário -->
        @include($thisdata->listStyle->view)
    
        <!-- Inclui paginação -->
        @include('Admin.Layouts.paginate')
    </section>
 
@endsection
