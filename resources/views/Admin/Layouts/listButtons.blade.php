<section id="main-button-list">
    @if(Auth::user()->listPermission[0]->delete)
    <div id="button-select" class="main-button-list" data-allselect="false" data-qtdselect="0">
        <span class="text-button-select-responsive" data-select="page">MARCAR TODOS</span>
    </div>
        @if (!isset($delete))
        <span id="button-delete" class="main-button-list" data-execute="0">APAGAR SELECIONADO(S)</span>
        @else
        <span id="button-restore" class="main-button-list" data-execute="0">RESTAURAR SELECIONADO(S)</span>
        @endif
    @endif
    @if(Auth::user()->listPermission[0]->add == 1 && !isset($delete))<a href="{{ url('/admin/'. $thisdata->pageConf->pageData->link . '/insert') }}{!! isset($thisdata->idFather) ? '/' . $thisdata->idFather : '' !!}" id="button-insert" class="main-button-list">INSERIR NOVO</a> @endif
    @if(Auth::user()->id_permission == 1)
        @if (isset($delete))
        <a href="{{ url('/admin/'. $thisdata->pageConf->pageData->link . '/') }}
            {!! isset($thisdata->idFather) ? '/' . $thisdata->idFather : '' !!}" id="button-insert" class="main-button-list">
            LISTA DE REGISTROS
        </a>
        @else
        <a href="{{ url('/admin/'. $thisdata->pageConf->pageData->link . '/lixeira') }}
            {!! isset($thisdata->idFather) ? '/' . $thisdata->idFather : '' !!}" id="button-trash" class="main-button-list">
            LIXEIRA
        </a>
        @endif
    @endif
</section>
<!-- <section id="main-button-list-responsive">
    @if(Auth::user()->listPermission[0]->delete)
    <div id="button-select-responsive" class="main-button-list-responsive" data-allselect="false" data-qtdselect="0">
        <span class="text-button-select-responsive" data-select="page">MARCAR</span>
    </div>
    <span id="button-delete-responsive" class="main-button-list-responsive" data-execute="0">APAGAR</span>
    @endif
    @if(Auth::user()->listPermission[0]->add == 1)<a href="{{ url('/admin/'. $thisdata->pageConf->pageData->link . '/insert') }}{!! isset($thisdata->idFather) ? '/' . $thisdata->idFather : '' !!}" id="button-insert-responsive" class="main-button-list-responsive">INSERIR</a> @endif
    @if(Auth::user()->id_permission == 1)<a href="{{ url('/admin/'. $thisdata->pageConf->pageData->link . '/lixeira') }}{!! isset($thisdata->idFather) ? '/' . $thisdata->idFather : '' !!}" id="button-trash-responsive" class="main-button-list-responsive">LIXEIRA</a> @endif
</section> -->