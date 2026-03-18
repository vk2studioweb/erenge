<section id="main-children-thispage">
    <ul id="main-list-children-thispage">
        @foreach($thisdata->pageConf->pageChildren as $key=>$childrem)
            @if(empty($childrem->link))
                <li class="children-disable"><span>{{ $childrem->name }}</span></li>
            @else
                <li>
                @if($childrem->link == 'upload')
                        @php $pagelink = $thisdata->pageConf->pageData->link; @endphp
                        <a href="{{ url('/admin/' . $childrem->link . '/' . $pagelink . '/' . $thisdata->listRegister[0]->$collumnId) }}" class="">{{ $childrem->name }}</a>
                    @else
                        <a href="{{ url('/admin/' . $childrem->link . '/' . $thisdata->listRegister[0]->$collumnId) }}" class="">{{ $childrem->name }}</a>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</section>