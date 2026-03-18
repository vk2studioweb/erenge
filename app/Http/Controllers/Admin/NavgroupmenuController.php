<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroupmenu;
use Illuminate\Http\Request;
use DB;

class NavgroupmenuController extends Controller
{
    public function __construct()
    {
        $this->_model = Navgroupmenu::class;                                              // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "navgroup";                                         //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "id_group";                                     //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function getRadioCorrect($register)
    {
        $register[0]->opcao1 = ($register[0]->visible == 1) ? true : false;
        $register[0]->opcao2 = ($register[0]->visible == 0) ? true : false;
        return $register;
    }

    public function checkDataBeforeLoad($register)
    {
        //função para teste
        $register = $this->getRadioCorrect($register);
        return $register;
    }

    //Função que vai criar pemissao para todos os usuarios do novo menu criado
    private function createPermissionForAllUser($idMenu, $inputs)
    {
        //Pegar todos os usuario
        $allUser = DB::table('vpr_login_users')->get();

        //cria variaveis para efetuaar a inclusao
        $idGrupoMenu = $inputs['id_group']; //Inputs é a variavel enviada via post do formulario

        //Inicia Inclusão de permissao para cada um dos usuarios do banco
        foreach($allUser as $key=>$user)
        {
            //Cria array dinamico de inclusao de dados
            $permission = array('id_user'=>$user->id_login_user, 'id_group'=>$idGrupoMenu, 'id_menu'=>$idMenu, 'view'=>0, 'edit'=>0, 'add'=>0, 'delete'=>0, 'upload'=>0, 'status'=>0);

            DB::table('vpr_permission')->insert($permission);
        }
    }

    //Função cria sub menu padão de forma automatizada
    private function createChildreamMenu($idMenu)
    {
        //Array de itens default para inclusão dos filhos
        $defaultChildream = [['id_menu'=>$idMenu, 'name'=>'Geral', 'link'=>'', 'default'=>1],['id_menu'=>$idMenu, 'name'=>'Upload', 'link'=>'upload', 'default'=>0]];
        DB::table('vpr_nav_group_menu_children')->insert($defaultChildream);

    }

    //Executa depois de efetuar um salve
    function executeAfterCreate($idMenu, $inputs)
    {
        $this->createPermissionForAllUser($idMenu, $inputs);
        $this->createChildreamMenu($idMenu);
    }

}
