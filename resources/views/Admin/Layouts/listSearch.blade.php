<section id="main-serach-line">
    <div id="main-form-serach">
      @if (isset($thisdata->idFather))
        <form id="" action="{{ route('admin.search', [$thisdata->pageConf->pageData->link, $thisdata->idFather])}}">
      @else
        <form id="" action="{{ route('admin.search', $thisdata->pageConf->pageData->link)}}">
      @endif
        <input name="search" class="input-search" placeholder="Buscar registro" />
        <button class="button-search">FILTRAR</button>
      </form>
    </div>
    <div id="main-register-per-page">

    </div>
    <!-- Inclui busca e paginação -->
    <div id="main-paginate">
      {{ $thisdata->listRegister->links() }}
    </div>  
    
</section>