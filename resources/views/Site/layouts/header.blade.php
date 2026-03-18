<header id="header">
    <div class="box boxRow">
        <a href="{{ route('home') }}" title="Erenge" aria-label="Erenge" id="headerLogo">
            <img src="{{ url('images/erenge.svg') }}" alt="Logo Erenge" id="headerLogoImg" loading="eager" decoding="async">
        </a>

        <section id="mainNav">
            <nav id="headerNav">
                <ul id="headerNavList">
                    <li class="headerNavItem">
                        <a href="{{ route('home') }}" class="headerNavLink" title="Home">Home</a>
                    </li>
                    <li class="headerNavItem">
                        <a href="{{ route('empresa') }}" class="headerNavLink" title="Empresa">Empresa</a>
                    </li>
                    <li class="headerNavItem">
                        <a href="{{ route('servicos') }}" class="headerNavLink" title="Serviços">Serviços</a>
                    </li>
                    <li class="headerNavItem">
                        <a href="{{ route('obras') }}" class="headerNavLink" title="Obras">Obras</a>
                    </li>
                    <li class="headerNavItem">
                        <a href="{{ route('trabalheConosco') }}" class="headerNavLink" title="Trabalhe Conosco">Trabalhe Conosco</a>
                    </li>
                    <li class="headerNavItem">
                        <a href="{{ route('contato') }}" class="headerNavLink" title="Contato">Contato</a>
                    </li>
                    <li class="headerNavItem headerNavItemIntranet">
                        <a href="{{ route('intranet') }}" class="headerNavLinkIntranet" title="Intranet">Intranet</a>
                    </li>
                </ul>
            </nav>

            <button id="headerMenuBtn" aria-label="Abrir menu" aria-expanded="false">
                <span class="headerMenuBtnBar"></span>
                <span class="headerMenuBtnBar"></span>
                <span class="headerMenuBtnBar"></span>
            </button>
        </section>
    </div>
</header>
