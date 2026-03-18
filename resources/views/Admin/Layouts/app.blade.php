<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ config('app.namePainel', 'http://www.vk2.com.br') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.namePainel', 'Painel Administrativo') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/App/jquery.js') }}"></script>

    <script src="{{ asset('js/Admin/jquery.form.js') }}"></script>
    <script src="{{ asset('js/Admin/jquery.validation.js') }}"></script>
    <script src="{{ asset('js/Admin/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/Admin/jquery.mask.js') }}"></script>

    <script src="{{ asset('js/Admin/forms.js') }}"></script>
    <script src="{{ asset('js/Admin/app.js') }}"></script>
    <script src="{{ asset('js/Admin/delete.js') }}"></script>
    @stack('scripts')
    <!-- Fonts -->

    <!-- Upload -->
    <script src="{{ asset('js/Admin/dropzone.js') }}"></script>
    <script src="{{ asset('js/Admin/dropzone-config.js') }}"></script>
    <link href="{{ asset('css/Admin/dropzone.css') }}" rel="stylesheet">
    <script>
        Dropzone.autoDiscover = false;
    </script>

    <!-- Data Tables -->
    <link href="{{ asset('datatables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/datatableTheme.css') }}" rel="stylesheet">
    <script src="{{ asset('datatables/datatables.js') }}"></script>
    <script>
        let dataTableLang = "{{ asset('/datatables/lang/pt-BR.json') }}"
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/ui-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Admin/responsive.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- tinymce -->
    <script src="{{ asset('tinymce/tinymce.min.js') }}" defer></script>


    <!-- Constantes para JS -->
    <script>
        var url_site = "{{ url('') . '/admin/' . $thisdata->pageConf->pageData->link . '/' }}",
            urlAssetCSS = "{{ asset('css/') }}";
    </script>
    <script>
        var url_raiz = "{{ url('') . '/admin/' }}",
            urlAssetCSS = "{{ asset('css/') }}",
            urlCssAdmin = "{{ asset('css/Admin/app.css') }}";
    </script>
</head>

<body data-theme="{{ Auth::user()->theme ?? 'dark' }}">
    <!-- Header -->
    <header id="header">
        <a class="navbar-brand" href="{{ url('/admin') }}">{{ config('app.namePainel', 'Painel Administrativo') }}</a>
        <i class="icon-collect-menu ui-admin-text-left-alignment"></i>
        <section id="main-top-bar">
            <ul id="main-top-shorts" class="top-bar">
                <li class="notificationArea">
                    <i class="icon-alert ui-admin-alarm-bell-outline"></i>
                    @if (Auth::user()->notifications->count() > 0)
                        <span class="notificationBubble">
                            {{ Auth::user()->notifications['count'] > 9 ? '9+' : Auth::user()->notifications['count'] }}</span>
                        <div class="notificationMenu" style="display: none">
                            <div class="notificationList">
                                @foreach (Auth::user()->notifications['result'] as $notification)
                                    <div class="notification">
                                        <div class="notificationIcon">
                                            <i class="ui-admin-{{ $notification['icon'] }}"></i>
                                        </div>
                                        <a class="notificationDescription"
                                            {{ $notification['type'] != 'info' ? 'href=' . $notification['type'] : '' }}>
                                            <p>{{ $notification['title'] }}</p>
                                            <small>{{ $notification['message'] }}</small>
                                        </a>

                                        <i data-notification="{{ $notification->id_notification }}"
                                            class="notificationClose ui-admin-cross-remove-sign"></i>
                                    </div>
                                @endforeach
                            </div>
                            <div class="notificationOptions">
                                <p id="notificationReadAll">Marcar todas como lidas</p>
                                <p id="notificationCloseOption"> Fechar </pi>
                            </div>
                        </div>
                    @endif
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="logout-link"><i
                                class="icon-shutdown ui-admin-logout"></i><span>Sair</span></button>
                    </form>
                </li>
                <li class="main-item-menu-responsive"><i id="menu-responsive" class="icon-menu ui-admin-menu"></i></li>
            </ul>
            <a href="{{ route('usuario.perfil') }}">
                <section id="main-top-user" class="top-bar">
                    <figure class="main-header-user-image"><img class="header-user-image"
                            src="{{ Auth::user()->image }}" alt="Imagem do Usuario" title="Imagem do usuario" />
                    </figure>
                    <div class="group-dates-user">
                        <span class="indentificate-user">Olá, <strong>{{ Auth::user()->name }}</strong></span>
                        <span class="permisson-user">{{ Auth::user()->permission }}</span>
                    </div>
                </section>
            </a>
        </section>
    </header>
    <!-- END Header -->
    <!-- Inclusão Menu principal -->
    <aside id="main-sidebar" data-open="1">

        <ul id="sidebar-menu">
            <li class="treeview">
                <a class="main-name-group @if ($thisdata->pageConf->pageData->name == 'home') select-treeview @endif"
                    href="{{ url('/admin') }}" title="Voltar a pag. inicial" alt="Voltar a pag. inicial">
                    <i class="icon-group-sidebar-menu ui-admin-old-elevator-levels-tool"></i>
                    <span class="name-group">Dashboard</span>
                </a>
            </li>
            @foreach (Auth::user()->groups as $group)
                <li class="treeview">
                    <div class="main-name-group @if ($thisdata->pageConf->pageData->id_group == $group->id_nav_group) select-treeview @endif"
                        data-slide="{{ $thisdata->pageConf->pageData->id_group == $group->id_nav_group ? 'open' : 'close' }}">
                        <i class="icon-group-sidebar-menu ui-admin-folder-filled-shape"></i>
                        <span class="name-group">
                            {{ $group->name }}
                        </span>
                        <i
                            class="icon-open-sidebar-menu {{ $thisdata->pageConf->pageData->id_group == $group->id_nav_group ? 'ui-admin-down-arrow-angle' : 'ui-admin-left-angle-arrow' }}"></i>
                    </div>
                    <ul
                        class="treeview-menu {{ $thisdata->pageConf->pageData->id_group == $group->id_nav_group ? 'treeview-show' : '' }}">
                        @foreach ($group->menus as $menu)
                            @if ($menu->visible == true)
                                <li>
                                    <a href="{{ url('admin/' . $menu->link) }}">
                                        <i class="icon-link-page ui-admin-circle"></i>
                                        <span>{{ $menu->name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </aside>
    <!-- AND Inclusão Menu principal -->

    <!-- Inclusão do conteudo do site -->
    <section id="main-content">

        <!-- Conteudo de cada página -->
        @yield('content')
        <!-- AND Conteudo de cada página -->

    </section>
    <!-- AND Inclusão do conteudo do site -->


</body>

</html>
