<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use DB;
use Session;

class AuthAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $excludedPages = [
        "home",
        "error",
        "upload",
        "uploadfile",
        "uploadvideo",
        "perfil",
        "notifications",
        "removeimages"
    ];

    public function handle($request, Closure $next)
    {
        //Chama função que cria url base para login
        $this->setSessionURL($request);

        // Verifica se usuário esta logado
        if (Auth::check()) {
            // Se for usuário classe Admin (1)
            if (Auth::user()->id_class == 1) {
                // Verifica se está ativo/deletado
                if (Auth::user()->delete == 0 && Auth::user()->status == 1) {
                    $this->getUserDates();
                    $this->getImageUser();
                    $this->getNotifications();
                
                    if (empty(Auth::user()->menu))
                        $this->getNavMenu();

                    $this->getPermissions();

                    if ($this->checkPermission() != true) {
                        $this->getNavMenu();
                        return redirect('admin/error/permission');
                    }
                    return $next($request);
                }

                // Retorna usuário invalido
                Auth::logout();
                return redirect('/login')->withErrors(['notauthorized' => 'Not Authorized!']);
            }
        }

        if ($request->session()->has('baseUrl')) {
            //tratar url salva na sessao pegar apenas o path
            $url_partes = parse_url($request->url(0), PHP_URL_PATH);

            if (isset($url_partes)) {
                //tratar o path para pegar apenas o parametro de local de login
                $url_partes = explode('/', $url_partes);

                if (isset($url_partes)) {
                    //Define variavel com valor adequado da url
                    $access = $url_partes[1];
                    if ($access == 'lojista') {
                        return redirect('/entrar')->withErrors(['notlogged' => 'Not Logged!']);
                    }
                    return redirect('/login')->withErrors(['notlogged' => 'Not Logged!']);
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
    }

    protected function getUserDates()
    {
        $permission = DB::table('vpr_login_permissions')->where('id_login_permission', Auth::user()->id_permission)->get();
        Auth::user()->permission = $permission[0]->name;
    }

    protected function getImageUser()
    {
        Auth::user()->image = url('/files/admin/images/user.jpg');
        if (!empty(Auth::user()->profile_picture) && file_exists(public_path(Auth::user()->profile_picture))) {
            Auth::user()->image = url(Auth::user()->profile_picture);
        }
    }

    protected function getNotifications() {
        $result = \App\Models\Admin\Notification::where('read', 0)
        ->where('id_user', Auth::user()->id_login_user)
        ->orderBy('created_at', 'desc')->get();

        Auth::user()->notifications = collect();
        
        Auth::user()->notifications['count'] = $result->count();
        Auth::user()->notifications['result'] = $result; 
    }

    /**
     * Função de construçao de Menu para cada usuario
     *
     * $permission = Permissao de cada usuario
     * $groups = grupos de menus
     * $group_menu = menus de grupos permitidos
     */
    protected function getNavMenu()
    {
        Auth::user()->menu = collect(); // Cria coleção receber dados do sql
        $userId = Auth::user()->id_login_user; //Variavel com Id Usuario para sql

        Auth::user()->groups = DB::table('vpr_nav_group AS group')
            ->select('group.*')
            ->join('vpr_permission AS permission', 'group.id_nav_group', '=', 'permission.id_group')
            ->where('permission.id_user', $userId)
            ->where('group.status', true)
            ->where('group.delete', false)
            ->distinct()
            ->get();

        foreach (Auth::user()->groups as $key => $group) {

            Auth::user()->groups[$key]->menus = DB::table('vpr_nav_group_menu AS menu')
                ->select('menu.*')
                ->join('vpr_permission AS permission', 'menu.id_nav_group_menu', '=', 'permission.id_menu')
                ->where('permission.id_user', $userId)
                ->where('menu.id_group', $group->id_nav_group)
                ->where('menu.status', true)
                ->where('menu.delete', false)
                ->where(function ($query) {
                    $query->where('permission.view', '1')
                        ->orWhere('permission.edit', '1')
                        ->orWhere('permission.add', '1')
                        ->orWhere('permission.delete', '1')
                        ->orWhere('permission.upload', '1');
                })
                ->get();

        }

    }

    /**
     * Função que pega todas as permissoes do usuario
     */
    protected function getPermissions()
    {

        $userId = Auth::user()->id_login_user; //Variavel com Id Usuario para sql

        Auth::user()->listPermission = DB::table('vpr_permission AS permission')
            ->select('permission.*', 'menu.link')
            ->join('vpr_nav_group_menu AS menu', 'permission.id_menu', '=', 'menu.id_nav_group_menu')
            ->where('permission.id_user', $userId)
            ->where('menu.link', Request::segment(2))
            ->where('menu.status', true)
            ->where('menu.delete', false)
            ->get();
    }

    protected function checkPermission()
    {
        $thisPage = Request::segment(2);

        if (array_search($thisPage, $this->excludedPages) === false) {
            foreach (Auth::user()->listPermission as $permission) {

                if ($permission->link == $thisPage) {
                    return true;
                    break;
                }
            }
            return false;
        }

        return true;

    }

    protected function checkUrlForUser($request, $class)
    {
        if ($request->session()->has('baseUrl')) {
            //tratar url salva na sessao pegar apenas o path
            $url_partes = parse_url($request->url(0), PHP_URL_PATH);
            // dd($request->session()->get('baseUrl'));
            if (isset($url_partes)) {
                //tratar o path para pegar apenas o parametro de local de login
                $url_partes = explode('/', $url_partes);

                if (isset($url_partes)) {
                    //Define variavel com valor adequado da url
                    $access = $url_partes[1];
                    //Verifica qual o painel permitido do usuario
                    switch ($class) {
                        case 1:
                            $page = 'admin';
                            break;
                        case 2:
                            $page = 'lojista';
                            break;
                    }

                    //Testa para ver se a pagina que esta tentando acessar é a mesma do acesso permitido
                    if ($page != $access) {
                        return false;
                    }
                    return true;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
    }

    protected function setSessionURL($request)
    {
        // echo $request->session()->get('baseUrl') . 'here';
        if (!$request->session()->has('baseUrl')) {
            $request->session()->put('baseUrl', $request->url(0));
            $request->session()->save();
            // dd(session()->all());
        }
        if ($request->session()->has('baseUrl')) {
            if ($request->session()->get('baseUrl') == url('/login')) {
                dd('here');

            }
        }
    }


}