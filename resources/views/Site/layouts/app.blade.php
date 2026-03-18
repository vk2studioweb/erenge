<!DOCTYPE html>
<html lang="ptbr" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-TextLayoutMetrics" content="gdi"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="EO0K75DgR69XEtFMl2Ua0HMxNhAdJYZCLkvUh2cZY10" />
    <meta name="author" content="{{ config('app.namePainel', 'https://www.vk2.com.br') }}" />
    @yield('metatags-share')
    
    <!-- ============================== -->
    <!-- Fontes -->
    <!-- ============================== -->
    <link rel="preconnect" href="https://use.typekit.net" crossorigin>
    <link rel="preconnect" href="https://p.typekit.net" crossorigin>
    <link rel="dns-prefetch" href="https://use.typekit.net">

    <link rel="preload" as="style" href="https://use.typekit.net/lzg7wdz.css" />
    <link rel="preload" as="style" href="https://use.typekit.net/rll4xln.css" />

    <link rel="stylesheet" href="https://use.typekit.net/lzg7wdz.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://use.typekit.net/rll4xln.css" media="print" onload="this.media='all'">

    <noscript>
        <link rel="stylesheet" href="https://use.typekit.net/lzg7wdz.css">
        <link rel="stylesheet" href="https://use.typekit.net/rll4xln.css">
    </noscript>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var link = document.createElement("link");
            link.rel = "stylesheet";
            link.href = "https://use.typekit.net/lzg7wdz.css";
            document.head.appendChild(link);

            var link2 = document.createElement("link");
            link2.rel = "stylesheet";
            link2.href = "https://use.typekit.net/rll4xln.css";
            document.head.appendChild(link2);
        });
    </script>

    <!-- ============================== -->
    <!-- JS otimizado -->
    <!-- ============================== -->
    {{-- <script src="{{ mix('js/main.min.js') }}" defer></script>
    <script src="{{ mix('js/extras.min.js') }}" defer></script> --}}


     <!-- Scripts -->
    <script src="{{ asset('js/App/jquery.js') }}" defer></script>
    <script src="{{ asset('js/Site/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/Site/jquery.mask.js') }}" defer></script>
    <script src="{{ asset('js/Site/jquery.validation.js') }}" defer></script>
    <script src="{{ asset('js/Site/jquery.form.js') }}" defer></script> <script src="{{ asset('js/Site/jquery.positioning.vk2.js') }}" defer></script>
    <script src="{{ asset('js/Site/anime.min.js') }}" defer></script>
    <script src="{{ asset('js/Site/wow.js') }}" defer></script>
    <script src="{{ asset('js/Site/lightbox.js') }}" defer></script>
    <script src="{{ asset('js/Site/slick.js') }}" defer></script>
    <script src="{{ asset('js/Site/lozad.js') }}" defer></script>
    <script src="{{ asset('js/Site/video.js') }}" defer></script>
    <script src="{{ asset('js/Site/leaflet.js') }}" defer></script>

    <script src="https://unpkg.com/video.js@7.10.2/dist/video.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script src="{{ asset('js/Site/forms.js') }}" defer></script>
    <script src="{{ asset('js/Site/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Site/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Site/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Site/lightbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Site/leaflet.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/Site/video.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/Site/erenge.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/video.js@7.10.2/dist/video-js.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/Site/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Site/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Site/app-responsive.css') }}" rel="stylesheet">
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ isset($thisdata->config->analytics) ? $thisdata->config->analytics : '' }}');</script>
    <!-- End Google Tag Manager -->

    <!-- HCaptcha -->
    {!! HCaptcha::renderJs('pt') !!}
    <!-- End Hcaptcha -->

     <!-- Constantes para JS -->
     <script>
        var url_site = "{{ url('/') }}";
        window.HELP_IMPROVE_VIDEOJS = false;
    </script>
</head>

    <body>
        <!-- Cookie Site -->
        @include('cookie-consent::index')
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{isset( $thisdata->config->analytics) ? $thisdata->config->analytics : '' }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- Header -->        
        @include('Site.layouts.header')
        <!-- END Header -->
                
        <!-- Content -->
        @yield('content')
        <!-- END Content -->

        <!-- Footer -->
        @include('Site.layouts.footer')
        <!-- END Footer -->
        </body>
</html>
