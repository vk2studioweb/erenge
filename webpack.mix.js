const mix = require("laravel-mix");
mix.disableNotifications();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 | Separação entre arquivos críticos e não críticos
 | para otimizar o carregamento e desempenho.
 |--------------------------------------------------------------------------
 */

// ==========================
// CSS - Arquivos críticos
// ==========================
mix.styles(
    [
        "public/css/reset.css",
        "public/css/Site/app.css",
        "public/css/Site/app-be.css",
        "public/css/Site/raix.css",
        "public/css/Site/app-julio.css",
        "public/css/Site/app-responsive.css",
        "public/css/Site/app-responsive-be.css",
        "public/css/Site/app-responsive-julio.css",
    ],
    "public/css/critical.min.css"
);

// ==========================
// CSS - Arquivos não críticos
// ==========================
mix.styles(
    [
        "public/css/Site/animate.min.css",
        "public/css/Site/slick.css",
        "public/css/Site/lightbox.css",
        "public/css/Site/leaflet.css",
        "public/css/Site/video.css",
    ],
    "public/css/noncritical.min.css"
);

// ==========================
// JS - Arquivos críticos
// ==========================
mix.combine(
    [
        "public/js/App/jquery.js",
        "public/js/Site/jquery-ui.min.js",
        "public/js/Site/jquery.mask.js",
        "public/js/Site/jquery.validation.js",
        "public/js/Site/jquery.form.js",
        "public/js/Site/jquery.positioning.vk2.js",
        "public/js/Site/lozad.js",
        "public/js/Site/slick.js",
        "public/js/Site/forms.js",
        "public/js/Site/app-julio.js",
        "public/js/Site/app.js",
    ],
    "public/js/main.js"
);

// ==========================
// JS - Arquivos não críticos
// ==========================
mix.combine(
    [
        "public/js/Site/anime.min.js",
        "public/js/Site/wow.js",
        "public/js/Site/lightbox.js",
        "public/js/Site/video.js",
        "public/js/Site/leaflet.js",
    ],
    "public/js/extras.js"
);

// ==========================
// Minificação
// ==========================
mix.minify("public/js/main.js");
mix.minify("public/js/extras.js");

// ==========================
// Versionamento (cache busting)
// ==========================
mix.version();
