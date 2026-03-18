<section id="pageHero" aria-label="Título da página">
    <div class="box boxRow" id="pageHeroContent">
        <h1 id="pageHeroTitle">{{ $thisdata->page }}</h1>
        <nav id="pageHeroBreadcrumb" aria-label="Breadcrumb">
            <span class="pageHeroBreadcrumbLabel">Você está em:</span>
            {{ Breadcrumbs::render() }}
        </nav>
    </div>
</section>