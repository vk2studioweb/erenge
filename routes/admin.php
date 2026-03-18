<?php

use Illuminate\Support\Facades\Route;

/*
| -----------------------------------------------------------------------
| Rotas Painel Administrativo - Versão Final e Absoluta
| -----------------------------------------------------------------------
*/

Route::get('/admin', function () {
    return redirect('admin/home');
});

Route::get('/chart/{chartref}/', 'Admin\ChartsController@drawchart');

// Grupo principal - Note que removemos o 'namespace' do grupo para usar o caminho completo no loop
Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {

    // Helper para o caminho dos Controllers
    $ctrlNamespace = "App\Http\Controllers\Admin";

    // --- Rotas de Sistema ---
    Route::get('/home', ["{$ctrlNamespace}\HomeController", 'dashboard'])->name('admin.home');
    Route::get('/viewlogs', ["{$ctrlNamespace}\LogHistoryController", 'index'])->name('admin.viewlogs');
    Route::get('/removeimages', ["{$ctrlNamespace}\RemoveImagesController", 'getArchive']);
    Route::get('/404', fn() => view('errors.404'))->name('404.error');

    // --- Perfil do Usuário (Nomes literais para o app.blade.php) ---
    Route::get('usuarios/perfil', ["{$ctrlNamespace}\UserProfileController", 'profile'])->name('usuario.perfil');
    Route::post('usuarios/perfil', ["{$ctrlNamespace}\UserProfileController", 'profilePost'])->name('usuario.post');
    Route::post('usuarios/perfil/foto', ["{$ctrlNamespace}\UserProfileController", 'profilePostPicture'])->name('usuario.postPicture');

    Route::get('usuariopassword', ["{$ctrlNamespace}\UsuariopasswordController", 'indexchildrem'])->name('usuario.usuariopasswordindex');
    Route::get('usuariopassword/{id}', ["{$ctrlNamespace}\UsuariopasswordController", 'edit'])->name('usuario.usuariopassword');
    Route::post('usuariopassword/toedit/{id}', ["{$ctrlNamespace}\UsuariopasswordController", 'toedit'])->name('usuario.usuariopasswordedit');

    // --- Busca Global ---
    Route::get('/{model}/search/{id_father?}', ["{$ctrlNamespace}\SearchController", 'search'])->name('admin.search');

    // --- Loop de Recursos Otimizados (Resolução de Herança) ---
    $resources = [
        // Rotas Padrão Painel
        'usuarios'       => 'UsuariosController',
        'mailconfig'     => 'MailConfigController',
        'configuration'  => 'ConfigurationController',
        'countries'      => 'CountriesController',
        'countriesstates'=> 'CountriesstatesController',
        'navgroup'       => 'NavgroupController',
        'networks'       => 'NetworksController',
        
        // Rotas Conteúdos Dinámicos Site
        'texts'          => 'TextsController',
        'textbusiness'   => 'TextbusinessController',
        'banners'        => 'BannersController',
        'servicos'       => 'ServicosController',
        'obras'          => 'ObrasController',
        'contatos'       => 'ContatosController',
        'beneficios'     => 'BeneficiosController',
        'filiais'        => 'FiliaisController',
        'outroscontatos' => 'OutrosContatosController',
        'noticias'       => 'NoticiasController',
        'address'       => 'AddressController',
        'polices'       => 'PolicesController',
       
    ];

    foreach ($resources as $slug => $controllerName) {
        $fullPath = "{$ctrlNamespace}\\{$controllerName}";

        Route::get("/{$slug}", [$fullPath, 'index'])->name("admin.{$slug}.index");
        Route::get("/{$slug}/insert", [$fullPath, 'newinsert'])->name("admin.{$slug}.insert");
        Route::get("/{$slug}/edit/{id}", [$fullPath, 'edit'])->name("admin.{$slug}.edit");
        
        Route::post("/{$slug}/create", [$fullPath, 'create']);
        Route::post("/{$slug}/toedit/{id}", [$fullPath, 'toedit']);
        Route::post("/{$slug}/delete", [$fullPath, 'delete']);
        Route::post("/{$slug}/delete/{id}", [$fullPath, 'deleteunique']);
        
        Route::get("/{$slug}/lixeira", [$fullPath, 'lixeira']);
        Route::post("/{$slug}/lixeira/restore", [$fullPath, 'restore']);
        Route::get("/{$slug}/updatestatus/{id}/{status}", [$fullPath, 'updateStatus']);
        Route::get("/{$slug}/consultarPagamento/{id}/{status}/{e2eid}", [$fullPath, 'consultarPagamento']);
        Route::get("/{$slug}/orderList/{order}/{collumn}", [$fullPath, 'orderList']);
    }

    //Rota personalizada verificar o PIX
    Route::get("/orders/consultarpix", ["{$ctrlNamespace}\OrdersController", 'consultarAllPix']);

    // --- Rotas Hierárquicas (Cidades, Menus, Estilos) ---
    // Usando nomes explícitos para garantir que o parâmetro {id} do pai seja passado
    
    // Menus e Submenus
    Route::prefix('navgroupmenu')->group(function () use ($ctrlNamespace) {
        $ctrl = "{$ctrlNamespace}\NavgroupmenuController";

        Route::get('/{id}', [$ctrl, 'indexchildrem']); // Lista menus de um grupo
        Route::get('/insert/{id}', [$ctrl, 'newinsertChildrem']);
        Route::get('/edit/{id}', [$ctrl, 'edit']);
        
        Route::post('/create', [$ctrl, 'createChildream']); 
        Route::post('/toedit/{id}', [$ctrl, 'toedit']);
        Route::post('/delete', [$ctrl, 'delete']);
        Route::post('/delete/{id}', [$ctrl, 'deleteunique']);

    });
    


    // O prefixo 'navmenuchildren' já está definido aqui
    Route::prefix('navmenuchildren')->group(function () use ($ctrlNamespace) {
        $ctrl = "{$ctrlNamespace}\NavgroupmenuchildrenController";

        Route::get('/{id}', [$ctrl, 'indexchildrem']);
        Route::get('/edit/{id}', [$ctrl, 'edit']);
        Route::get('/insert/{id}', [$ctrl, 'newinsertChildrem']);
        Route::get('/lixeira/{id}', [$ctrl, 'lixeira']);
        Route::post('/lixeira/restore', [$ctrl, 'restore']);
        Route::get('/orderList/{order}/{collumn}/{father}', [$ctrl, 'orderListChildrem']);
        Route::get('/updatestatus/{id}/{status}', [$ctrl, 'updateStatus']);
        
        // Agora a URL será: /admin/navmenuchildren/create
        Route::post('/create', [$ctrl, 'createChildream']); 
        
        Route::post('/toedit/{id}', [$ctrl, 'toedit']);
        Route::post('/delete', [$ctrl, 'delete']);
        Route::post('/delete/{id}', [$ctrl, 'deleteunique']);
    });

    // Estilos de Menu
    
    // Route::get('/navmenustyle/{id}', ["{$ctrlNamespace}\NavgroupmenustyleController", 'indexchildrem']);
    // Route::get('/navmenustyle/insert/{id}', ["{$ctrlNamespace}\NavgroupmenustyleController", 'newinsertChildrem']);

    // // Estilos de Coluna
    // Route::get('/navgroupmenustylecollumn/{id}', ["{$ctrlNamespace}\NavgroupmenustylecollumnController", 'loadcollumn']);
    // Route::get('/navgroupmenustylecollumn/edit/{id}', ["{$ctrlNamespace}\NavgroupmenustylecollumnController", 'editcollumn']);
    // Route::post('/navgroupmenustylecollumn/insert', ["{$ctrlNamespace}\NavgroupmenustylecollumnController", 'insertcollumn']);

    // --- Estilos de Menu (Configuração Visual) ---
    Route::prefix('navmenustyle')->group(function () use ($ctrlNamespace) {
        $ctrl = "{$ctrlNamespace}\NavgroupmenustyleController";

        Route::get('/{id}', [$ctrl, 'indexchildrem']);
        Route::get('/insert/{id}', [$ctrl, 'newinsertChildrem']);
        Route::get('/edit/{id}', [$ctrl, 'edit']);
        
        // Se você tiver edição e deleção de estilos, adicione aqui:
        Route::post('/create', [$ctrl, 'createChildream']);
        Route::post('/toedit/{id}', [$ctrl, 'toedit']);
        Route::post('/delete', [$ctrl, 'delete']);
    });

    // --- Colunas de Estilo (Sub-nível dos Estilos) ---
    Route::prefix('navgroupmenustylecollumn')->group(function () use ($ctrlNamespace) {
        $ctrl = "{$ctrlNamespace}\NavgroupmenustylecollumnController";

        Route::get('/{id}', [$ctrl, 'loadcollumn']);
        Route::get('/edit/{id}', [$ctrl, 'editcollumn']);
        
        Route::post('/insert', [$ctrl, 'insertcollumn']);
        Route::post('/toedit', [$ctrl, 'updatecollumn']); // Ajustado para o seu método updatecollumn
        Route::post('/remove', [$ctrl, 'deletecollumn']); // Ajustado para o seu método deletecollumn
    });

    // Cidades (Filhas de Estados)
    Route::get('/countriesstatescities/{id}', ["{$ctrlNamespace}\CountriesstatescitiesController", 'indexchildrem']);
    Route::get('/countriesstatescities/edit/{id}', ["{$ctrlNamespace}\CountriesstatescitiesController", 'edit']);
    Route::get('/countriesstatescities/insert/{id}', ["{$ctrlNamespace}\CountriesstatescitiesController", 'newinsertChildrem']);

    // --- Gestão de Uploads ---
    Route::prefix('upload')->group(function () use ($ctrlNamespace) {
        $upCtrl = "{$ctrlNamespace}\UploadController";
        Route::get('/delete/{id}', [$upCtrl, 'deleteUpload']);
        Route::get('/{page}/{id}', [$upCtrl, 'uploadindex']);
        Route::post('/{page}/{id}/save', [$upCtrl, 'save']);
        Route::post('/sortable', [$upCtrl, 'sortable']);
        Route::post('/gallery/{page}', [$upCtrl, 'galleryUpload']);
        Route::get('/gallery/images/{menu}/{page?}', [$upCtrl, 'galleryPage']);
    });

    Route::prefix('uploadfile')->group(function () use ($ctrlNamespace) {
        $upCtrl = "{$ctrlNamespace}\UploadController";
        Route::get('/{page}/{id}', [$upCtrl, 'uploadindexfile']);
        Route::post('/{page}/{id}/savefile', [$upCtrl, 'savefile']);
        Route::get('/delete/{id}', [$upCtrl, 'deleteUpload']);
    });

    Route::prefix('uploadvideo')->group(function () use ($ctrlNamespace) {
        $upCtrl = "{$ctrlNamespace}\UploadController";
        Route::get('/{page}/{id}', [$upCtrl, 'uploadindexvideo']);
        Route::post('/{page}/{id}/savevideo', [$upCtrl, 'savevideo']);
        Route::get('/delete/{id}', [$upCtrl, 'deleteUpload']);
    });

    // --- Permissões ---
    Route::get('/permissoes/{id}', ["{$ctrlNamespace}\PermissoesController", 'loadPermission']);
    Route::post('/permissoes/update', ["{$ctrlNamespace}\PermissoesController", 'updatepermissoes']);

});