<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Usuarios;
use Auth;
use Illuminate\Http\Request;
use DB;

class UsuariosController extends Controller
{
    
    public function __construct()
    {
        $this->_model = Usuarios::class;                                                  // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null";                                             //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }
    
    /**
     * Funçao de correçao de nome de funções
     */
    public function get_status($line)
    {
        if($line->status == 0) return 'Inativo';
        if($line->status == 1) return 'Ative';
    }
    public function get_created_at($line)
    {
        return date('d/m/Y', strtotime($line->created_at));
    }

    public function getDataForeignKey()
    {
        $this->foreingKey = new \stdClass;

        $classes = DB::table('vpr_login_classes')->select('name', 'id_login_class as id')->where('status', true)->where('delete', false)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->foreingKey->classes = ['0' => 'Selecione'] + collect($classes)->toArray();
        
        $permissoes = DB::table('vpr_login_permissions')->select('name', 'id_login_permission as id')->where('status', true)->where('delete', false)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->foreingKey->permissoes = ['0' => 'Selecione'] + collect($permissoes)->toArray();
        
        return $this->foreingKey;
    } 

    public function getContentForForeignKey()
    {
        $this->foreingKey = new \stdClass;

        $classes = DB::table('vpr_login_classes')->select('name', 'id_login_class as id')->where('status', true)->where('delete', false)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->foreingKey->classes = ['0' => 'Selecione'] + collect($classes)->toArray();
        
        $permissoes = DB::table('vpr_login_permissions')->select('name', 'id_login_permission as id')->where('status', true)->where('delete', false)->orderBy('name', 'asc')->pluck('name', 'id');
        $this->foreingKey->permissoes = ['0' => 'Selecione'] + collect($permissoes)->toArray();
        
        return $this->foreingKey;
    }

    function checkBeforeInsert($inputs)
    {
        $inputs['password'] = bcrypt($inputs['password']);
        return $inputs;
    }

     //Função que vai criar pemissao para todos os usuarios do novo menu criado
     private function createPermissionForAllMenus($idUsurio)
     {
         //Pegar todos os menus
         $allMenus = DB::table('vpr_nav_group_menu')->get();
 
         //Inicia Inclusão de permissao para cada um dos usuarios do banco
         foreach($allMenus as $key=>$menus)
         {
             //Cria array dinamico de inclusao de dados
             $permission = array('id_user'=>$idUsurio, 'id_group'=>$menus->id_group, 'id_menu'=>$menus->id_nav_group_menu, 'view'=>0, 'edit'=>0, 'add'=>0, 'delete'=>0, 'upload'=>0, 'status'=>0);
 
             DB::table('vpr_permission')->insert($permission);
         }
     }

    //Executa depois de efetuar um salve
    function executeAfterCreate($idUsurio, $inputs)
    {
        if($inputs['id_class'] == 1){
            $this->createPermissionForAllMenus($idUsurio);
        }
    }


    public function profile() {

        $this->pageConf->pageData->user = Auth::user();

        dd($this->pageConf);
    }

}
