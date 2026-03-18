<section id="main-identification-page">
    <h3 class="title-page-identification">Página(s)</h3>
    @if($thisdata->pageConf->pageFather !== 'null')
    <a class="link-identificate-page" href="{{ url('/admin/'.$thisdata->pageConf->pageFather) }}">{{ $thisdata->pageConf->pageFather }}</a>
    <hr/>
    @endif
    <h2 class="page-select-identification">{{ $thisdata->pageConf->pageData->name }}</h2>
</section>