<section id="main-list-data">
{!! csrf_field() !!}
    <ul id="title-list-data"  >
        <li class="item-title-date size-item-select"><span class="text-item-title-data">SEL</span></li>
        <li class="item-title-date size-item-status"><span class="text-item-title-data">STATUS</span></li>
        @foreach($thisdata->listItemsTitle as $title)
        @if($title->order == 'asc' && $title->default == 1) @php $order='desc'; @endphp @elseif($title->order == 'asc'
        && $title->default != 1) @php $order = 'asc'; @endphp @elseif($title->order == 'desc' && $title->default != 1)
        @php $order = 'desc'; @endphp @else @php $order = 'asc'; @endphp @endif
        <li class="item-title-date item-set-size size-{{ $title->collumn }}-{{ $title->size }}" data-collumn="{{ $title->collumn }}"
            data-size="{{ $title->size }}">
            @php $url = url('/admin/' . $thisdata->pageConf->pageData->link . '/orderList/'. $order . '/'. $title->collumn); @endphp
            @if(isset($thisdata->idFather) &&  !empty($thisdata->idFather)) @php $url .= '/' . $thisdata->idFather; @endphp @endif
            <a href="{{ $url }}" title="Ordenar Coluna Select" alt="Ordenar Coluna Select" class="button-order">
                <span class="text-item-title-data">{{ $title->name }}</span>
                <hr class="button-order-inative button-orderasc ui-admin-arrows-up-and-down-filled-triangles" />
            </a>
        </li>
        @endforeach
    </ul>
    <ul class="main-list-data">
        @foreach($thisdata->listRegister as $key=>$line)
        <li class="line-data {{ !($key % 2) ? 'line-color2' : 'line-color1' }}">
            <ul class="main-items-list-data">
                @php $collumnId = $thisdata->listItemsTitle[0]->collumn; @endphp
                <li class="item-list-date size-item-select"><input type="checkbox" name="selectitemlist[{{ $line->$collumnId }}]"
                        value="{{ $line->$collumnId }}" class="selectitemlist" /></li>
                <li class="item-list-date size-item-status"><button id="button-status-{{ $line->$collumnId }}" data-id="{{ $line->$collumnId }}"
                        data-status="{{ $line->status }}" class="button-status {{ !($line->status % 2) ? 'button-status-inactive' : 'button-status-active' }}">{{
                        !($line->status % 2) ? 'Inativo' : 'Ativo' }}</button></li>

                @foreach($thisdata->listItemsTitle as $collumn)

                @if($collumn->function == true) @php $collumnName = $collumn->collumn . '_mask'; @endphp
                @else @php $collumnName = $collumn->collumn; @endphp
                @endif

                <li class="item-list-date size-{{ $collumn->collumn }}-{{ $collumn->size }}"><a href="{{ url('/admin/' . $thisdata->pageConf->pageData->link . '/edit/' . $line->$collumnId) }}">{!! strip_tags($line->$collumnName) !!}</a></li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
</section>
