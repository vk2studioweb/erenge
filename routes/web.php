<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$ctrlNamespace = "App\Http\Controllers\Site";

// --- Home ---
Route::get('/', ["{$ctrlNamespace}\HomeController", 'index'])->name('home');

// --- Empresa ---
Route::get('/empresa', ["{$ctrlNamespace}\EmpresaController", 'index'])->name('empresa');

// --- Serviços ---
Route::get('/servicos', ["{$ctrlNamespace}\ServicosController", 'index'])->name('servicos');
Route::get('/servicos/{slug}/{id}', ["{$ctrlNamespace}\ServicosController", 'show'])->name('servicos.show');

// --- Obras ---
Route::get('/obras', ["{$ctrlNamespace}\ObrasController", 'index'])->name('obras');
Route::get('/obras/{slug}/{id}', ["{$ctrlNamespace}\ObrasController", 'show'])->name('obras.show');

// --- Trabalhe Conosco ---
Route::get('/trabalhe-conosco', ["{$ctrlNamespace}\TrabalheConoscoController", 'index'])->name('trabalheConosco');
Route::post('/trabalhe-conosco/enviar', ["{$ctrlNamespace}\TrabalheConoscoController", 'send'])->name('trabalheConosco.send');

// --- Contato ---
Route::get('/contato', ["{$ctrlNamespace}\ContatoController", 'index'])->name('contato');
Route::post('/contato/enviar', ["{$ctrlNamespace}\ContatoController", 'send'])->name('contato.send');

// --- Notícias ---
Route::get('/noticias', ["{$ctrlNamespace}\NoticiasController", 'index'])->name('noticias');
Route::get('/noticias/{slug}/{id}', ["{$ctrlNamespace}\NoticiasController", 'show'])->name('noticias.show');

// --- Institucional / Footer ---
Route::get('/termos/{slug}', ["{$ctrlNamespace}\TermosController", 'index'])->name('termo');
Route::get('/mapa-do-site', ["{$ctrlNamespace}\InstitucionalController", 'mapaSite'])->name('mapaSite');

// --- Intranet (redireciona para admin) ---
Route::get('/intranet', function () {
    return redirect('admin/home');
})->name('intranet');
/*
| -----------------------------------------------------------------------
|  Fallback
| -----------------------------------------------------------------------
*/
Route::fallback('Site\ErrorController@index')->name('404');

/*
| -----------------------------------------------------------------------
| Resset Password
| -----------------------------------------------------------------------
*/
Route::get('/email', function (){
    return view('Emails.passwordReset');
});

/*
| -----------------------------------------------------------------------
|  Rotas Site
| -----------------------------------------------------------------------
*/
Route::get('/', 'Site\HomeController@index')->name('home');




/*
| -----------------------------------------------------------------------
| Rotas Auth
| -----------------------------------------------------------------------
*/

Auth::routes(['register' => false]);

/*
| -----------------------------------------------------------------------
| Rotas de Configuração
| -----------------------------------------------------------------------
*/
Route::get('/route', function () {
    $exitCode = Artisan::call('route:clear');
    return Artisan::output();
});
Route::get('/config', function () {
    $exitCode = Artisan::call('config:clear');
    return Artisan::output();
});
Route::get('/cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return Artisan::output();
});
Route::get('/view', function () {
    $exitCode = Artisan::call('view:clear');
    return Artisan::output();
});
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize:clear');
    return Artisan::output();
});