<section id="main-button-list">
    @if(Auth::user()->listPermission[0]->edit == 1)<button id="button-insert" class="main-button-list" type="submit" form="mainFormInsert">SALVAR</button> @endif
    <a href="{{ isset($thisdata->originIndex) ? $thisdata->originIndex : URL::previous() }}" id="button-goBack" class="main-button-list">VOLTAR</a>
    @if(Auth::user()->listPermission[0]->delete)
    <span data-id="{{ $thisdata->listRegister[0]->$collumnId }}" id="button-delete-one" class="main-button-list">APAGAR CADASTRO</span>
    @endif
</section>