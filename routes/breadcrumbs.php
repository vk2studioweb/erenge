<?php

use App\Models\Admin\TextsBussiness;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Página Inicial', route('home'));
});

// Empresa
Breadcrumbs::for('empresa', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Empresa', route('empresa'));
});

// Serviços
Breadcrumbs::for('servicos', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Serviços', route('servicos'));
});

Breadcrumbs::for('servicos.show', function (BreadcrumbTrail $trail, $slug, $id) {
    $trail->parent('servicos');
    $trail->push($slug);
});

// Obras
Breadcrumbs::for('obras', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Obras', route('obras'));
});

Breadcrumbs::for('obras.show', function (BreadcrumbTrail $trail, $slug, $id) {
    $trail->parent('obras');
    $trail->push($slug);
});

// Notícias
Breadcrumbs::for('noticias', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Notícias', route('noticias'));
});

Breadcrumbs::for('noticias.show', function (BreadcrumbTrail $trail, $slug, $id) {
    $trail->parent('noticias');
    $trail->push($slug);
});

// Trabalhe Conosco
Breadcrumbs::for('trabalheConosco', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Trabalhe Conosco', route('trabalheConosco'));
});

// Contato
Breadcrumbs::for('contato', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Contato', route('contato'));
});

// Política de Privacidade
Breadcrumbs::for('termo', function (BreadcrumbTrail $trail, $slug) {
    $trail->parent('home');
    $trail->push($slug);
});

// Mapa do Site
Breadcrumbs::for('mapaSite', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Mapa do Site', route('mapaSite'));
});
