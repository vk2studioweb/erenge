<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Request as Requestform;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Collection;
use Auth;
use DB;
use App\Models\Admin\Navgroupmenu;
use App\Models\Admin\Navgroupmenuchildren;
use Illuminate\Support\Facades\Storage;
use Log;
use PhpParser\Node\Stmt\TryCatch;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * Funções protegidas, carregadas das funçoes de carregamento
     * v 1.0.0
     * Vk2 Studio WEB
     * 2018-11-13
     */

    // Funçao para pegar nome da pagina no banco de dados
    public function getPageData()
    {
        $navGroupMenu = Navgroupmenu::where('link', Request::segment(2))->get();
        if ($navGroupMenu->isEmpty()) {
            //Se Pagina não puder ser carregada retorna para a home
            $navGroupMenu[0] = new \stdClass;
            $navGroupMenu[0]->id_nav_group_menu = 0;
            $navGroupMenu[0]->id_group = 0;
            $navGroupMenu[0]->name = "home";
            $navGroupMenu[0]->link = 'home';
        }
        return $navGroupMenu[0];
    }

    // Funçao para pegar submenus de pag. selecionada
    public function getPageChildren()
    {
        $navGroupMenu = Navgroupmenu::where('link', Request::segment(2))->get();
        if ($navGroupMenu->count() > 0) {
            $children = Navgroupmenuchildren::where('id_menu', $navGroupMenu[0]->id_nav_group_menu)->get();
            return $children;
        }
        return "null";
    }

    protected function getListStyleFromUser($pageData, $user)
    {
        return DB::table('vpr_user_style_menu as user_style')
            ->join('vpr_list_style as style', 'user_style.id_style', '=', 'style.id_style')
            ->select('style.*', 'user_style.id_style as default')
            ->where('user_style.id_menu', $pageData->id_nav_group_menu)
            ->where('user_style.id_user', $user)
            ->get();
    }

    protected function getListStyleFromPage($pageData)
    {
        return DB::table('vpr_nav_group_menu_style as menu_style')
            ->join('vpr_list_style as style', 'menu_style.id_style', '=', 'style.id_style')
            ->select('menu_style.id_menu_style as id_menu_style', 'style.*', 'menu_style.default as default')
            ->where('menu_style.id_menu', $pageData->id_nav_group_menu)
            ->where('menu_style.delete', 0)
            ->orderBy('menu_style.default', 'desc')
            ->get();
    }

    protected function getListViewDefault($thisStyle)
    {
        foreach ($thisStyle as $key => $style) {
            if ($style->default == 1) {
                return "Admin/Layouts/{$style->file}";
                break;
            }
        }
        return "Admin/Layouts/listLines";
    }

    /**
     * Funçao que vai pegar os dados da primary Key da tabela selecionada
     */

    private function getPrimaryKey($pageData)
    {
        $collumn = DB::table('vpr_nav_group_menu_style as menu_style')
            ->join('vpr_list_style as style', 'menu_style.id_style', '=', 'style.id_style')
            ->join('vpr_nav_group_menu_style_collumns as collumns', 'menu_style.id_menu_style', '=', 'collumns.id_menu_style')
            ->select('collumns.collumn')
            ->where('menu_style.id_menu', $pageData->id_nav_group_menu)
            ->where('collumns.default', 1)
            ->where('collumns.delete', 0)
            ->get();
        if ($collumn->count() >= 1)
            return $collumn[0]->collumn;
        if ($collumn->count() < 1)
            return 'id';
    }

    /**
     * Função que pega o ID da pagina pai
     */

    public function getFatherId($page)
    {
        $return = 0; //Cria variavel de retorno com valor padrão

        foreach (Auth::user()->groups as $group) {
            foreach ($group->menus as $menu) {
                if ($menu->link == $page) {
                    return $menu->id_nav_group_menu;
                    break;
                }
            }
        }
        return $return;
    }


    public function getListStyle($pageData)
    {

        $listStyle = new \stdClass; //Objeto padrão
        $listStyle->view = "Admin/Layouts/listLines"; //view Padão
        $listStyle->listStyle = collect([]); //Collection zerado

        // Faz verificaçao se existe estilo para usuario logado para pagina que ele está acessando
        $thisStyle = $this->getListStyleFromUser($pageData, Auth::user()->id_login_user);

        // Caso resultado da Query retorne vazio faz teste de padrões de listagem geral da página
        if ($thisStyle->isEmpty()) {
            // Query de verificaçao de listagem padrão do sistema
            $thisStyle = $this->getListStyleFromPage($pageData);

            // Caso retorne vazio a query interrompe execuçao da função retornando view padrão
            if ($thisStyle->isEmpty()) {
                $thisStyle = $listStyle->listStyle;
            }
        }

        // Passa em formato de String a view default para o sistema
        $listStyle->view = $this->getListViewDefault($thisStyle);
        $listStyle->listStyle = $thisStyle;

        return $listStyle;
    }

    // Funçao para pegar os titulos da listagem
    public function getTitleforList($listStyle)
    {
        $listTitle = new \stdClass; //Objeto padrão
        //Checagem padrão para ver se existem dados de style setados
        if (!$listStyle->listStyle->isEmpty()) {
            return DB::table('vpr_nav_group_menu_style_collumns as colluns')->where('colluns.id_menu_style', $listStyle->listStyle[0]->id_menu_style)->where('colluns.delete', false)->get();
        }
    }

    // Seta ordenaçao inversa da coluna que foi selecionada na listagem
    private function setNewOrderForList($listItemsTitle, $order, $collumn)
    {
        foreach ($listItemsTitle as $key => $items) {
            if ($items->collumn != $collumn) {
                $listItemsTitle[$key]->default = 0;
            }
            if ($items->collumn == $collumn) {
                $listItemsTitle[$key]->default = 1;
                $listItemsTitle[$key]->order = $order;
            }

        }
        return $listItemsTitle;
    }

    public function getOrderSelect($listItemsTitle)
    {
        $configSelect = new \stdClass;
        $configSelect->order = 'asc';
        $configSelect->collumn = '';
        foreach ($listItemsTitle as $collumn) {
            if ($collumn->default == 1) {
                $configSelect->order = $collumn->order;
                $configSelect->collumn = $collumn->collumn;
                break;
            }
        }
        if ($configSelect->collumn === '') {
            $configSelect->order = $listItemsTitle[0]->order;
            $configSelect->collumn = $listItemsTitle[0]->collumn;
        }

        return $configSelect;
    }

    /**
     * Função para organizar dados a serem exibidos
     */
    private function filteredData($rawData, $listItemsTitle)
    {
        foreach ($rawData as $key => $line) {
            foreach ($listItemsTitle as $collumn) {
                if (array_has(collect($line), $collumn->collumn)) {
                    $collumnRename = $collumn->collumn . '_mask';
                    $collumnName = $collumn->collumn;

                    if ($collumn->function == true) {
                        $nameFunction = 'get_' . $collumn->collumn;
                        $rawData[$key]->$collumnRename = $this->$nameFunction($line, $collumn->collumn);
                    }

                }
            }
        }
        return $rawData;
    }
    /**
     * Função que pega o dado para editar cadastro
     */
    private function getRegisterforEdit($id_register, $primaryKeyCollumn)
    {
        $listItems = new \stdClass;
        $rawData = $this->_model::where($primaryKeyCollumn, $id_register)->where('delete', false)->get();

        return $rawData;
    }

    /**
     * Função que pega os registros do banco de dados para a listagem
     */
    private function getRegisterforList($listItemsTitle)
    {
        $listItems = new \stdClass; //Objeto padrão

        $configSelect = $this->getOrderSelect($listItemsTitle);
        $rawData = $this->_model::where('delete', false)->orderBy($configSelect->collumn, $configSelect->order)->paginate(30);
        $rawData->paginate = $rawData->links();
        return $this->filteredData($rawData, $listItemsTitle);
    }

    private function getRegisterforTrash($listItemsTitle)
    {
        $listItems = new \stdClass; //Objeto padrão

        $configSelect = $this->getOrderSelect($listItemsTitle);
        $rawData = $this->_model::where('delete', true)->orderBy($configSelect->collumn, $configSelect->order)->paginate(30);
        $rawData->paginate = $rawData->links();

        return $this->filteredData($rawData, $listItemsTitle);
    }

    /**
     * Função que pega os registros de filhos no banco de dados para a listagem
     */
    private function getRegisterforListChildrem($listItemsTitle, $idFather, $collunIdFather)
    {
        $listItems = new \stdClass; //Objeto padrão
        $configSelect = $this->getOrderSelect($listItemsTitle);
        $rawData = $this->_model::where($collunIdFather, $idFather)->where('delete', false)->orderBy($configSelect->collumn, $configSelect->order)->paginate(30);
        $rawData->paginate = $rawData->links();
        return $this->filteredData($rawData, $listItemsTitle);
    }

    /**
     * Função principal para pegar os dados das tabelas
     *
     */
    private function pageListData($pageConf)
    {
        $thisPage = $pageConf->pageData->link;
        if ($thisPage != 'home' && $thisPage != 'error') {
            $thisDbResult = $this->_model::where('status', true)->paginate(30);
            return $thisDbResult;
        }
    }

    /**
     * Função de carregamento de valores de selects
     * Verifica se metodo chamado existe e o executa com parametro recebido
     */
    public function getSelectData($method, $id)
    {
        if (method_exists($this, $method)) {
            return call_user_func(array($this, $method), $id);
        }
    }

    /*
     *
     * Funções de Aleração de Status da listagem
     * v 1.0.0
     * Vk2 Studio WEB
     * 11/2018
     *
     */
    public function updateStatus($id, $status)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle); //Campos liberados para listagem

        $thisdata->newStatus = 0;
        $thisdata->response = array('success' => 'false', 'status' => $status);

        if ($status == 0)
            $thisdata->newStatus = 1;

        if ($this->_model::where($thisdata->listItemsTitle[0]->collumn, $id)->update(['status' => $thisdata->newStatus])) {
            $thisdata->response = array('success' => 'true', 'status' => $thisdata->newStatus);
        }

        echo json_encode($thisdata->response);

    }

    /*
     *
     * Funções de gerenciamento e carregamento
     * v 1.0.0
     * Vk2 Studio WEB
     * 2018-11-13
     *
     */


    /**
     * Function Index
     * Funçao de carregamento padrão de listagem de dados das paginas
     **/
    public function index(Request $request)
    {

        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        /*
         * Função de carregamento de listagem Geral
         */

        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle); //Campos liberados para listagem
        $thisdata->listRegister = $this->getRegisterforList($thisdata->listItemsTitle); //Pega todos os dados do banco de dados
        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.listdate')->with('thisdata', $thisdata);
    }

    /**
     * Function Index
     * Funçao de carregamento padrão de listagem de dados das paginas
     **/
    public function indexchildrem($idFather)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->idFather = $idFather; //Define Id do Pai do menu carregado para criar urls

        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle); //Campos liberados para listagem
        $thisdata->listRegister = $this->getRegisterforListChildrem($thisdata->listItemsTitle, $idFather, $thisdata->pageConf->collunIdFather); //Pega todos os dados do banco de dados

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.listdate')->with('thisdata', $thisdata);
    }

    /**
     * Function Index for Reports
     * Funçao de carregamento padrão de listagem de relatórios
     **/
    public function indexreports()
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento


        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); // pega Configuraçoes de stilo de listagem

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.reports')->with('thisdata', $thisdata);
    }

    /**
     * Function Order
     * Clone da funçao index so que recebe informações de ordem para modificar a listagem
     **/
    public function orderList($order, $collumn)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento


        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle); //Campos liberados para listagem
        $thisdata->listItemsTitle = $this->setNewOrderForList($thisdata->listItemsTitle, $order, $collumn); //Campos liberados para listagem
        $thisdata->listRegister = $this->getRegisterforList($thisdata->listItemsTitle); //Pega todos os dados do banco de dados

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.listdate')->with('thisdata', $thisdata);
    }

    /**
     *  Function for get name for primary key
     */
    public function fatherDate($idFather, $primaryKeyCollumn)
    {
        return $this->_model::where($primaryKeyCollumn, $idFather)->where('delete', false)->where('status', true)->get();
    }

    /**
     * Function Order dos menus Filhos
     * Clone da funçao index so que recebe informações de ordem para modificar a listagem
     **/
    public function orderListChildrem($order, $collumn, $idFather)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->idFather = $idFather; //Define Id do Pai do menu carregado para criar urls

        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle); //Campos liberados para listagem
        $thisdata->listItemsTitle = $this->setNewOrderForList($thisdata->listItemsTitle, $order, $collumn); //Campos liberados para listagem
        $thisdata->listRegister = $this->getRegisterforListChildrem($thisdata->listItemsTitle, $idFather, $thisdata->pageConf->collunIdFather); //Pega todos os dados do banco de dados

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.listdate')->with('thisdata', $thisdata);
    }

    /**
     * Function Index
     * Funçao de carregamento padrão de listagem de dados das paginas
     **/
    public function dashboard()
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.home')->with('thisdata', $thisdata);
    }

    /**
     * Carregamento de paginas de operações basicas 'Insert', 'Update/Edit', 'View'
     * v 1.0.0
     * Vk2 Studio WEB
     * 2018-11-13
     *
     */

    /**
     * Function Edit
     * Funçao que carrega dos dados do menu selecionado
     **/

    public function edit($id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        $this->idRegisterselect = $id;


        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key

        $thisdata->listRegister = $this->getRegisterforEdit($id, $thisdata->primaryKeyCollumn); //Pega todos os dados do banco de dados
        /*
         * Methodo verificar se existem dados de foreignkey */
        if (method_exists($this, 'getContentForForeignKey')) {
            $thisdata->listForeignKey = $this->getContentForForeignKey($thisdata->listRegister);
        }

        /*
         * Methodo Checa e trata dados antes de carregar a página */
        if (method_exists($this, 'checkDataBeforeLoad')) {
            $thisdata->listRegister = $this->checkDataBeforeLoad($thisdata->listRegister);
        }

        //Criação da URL para Editar
        $collumPrimarykay = $thisdata->primaryKeyCollumn;

        $thisdata->originIndex = $this->getOriginIndex();

        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link . '/toedit/' . $thisdata->listRegister[0]->$collumPrimarykay;


        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.update')->with('thisdata', $thisdata);
    }

    /**
     * Function Edit Personalizada
     * Funçao que carrega dos dados do menu selecionado para uma view personalizavel
     **/

    public function editCustomization($id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key
        $thisdata->listRegister = $this->getRegisterforEdit($id, $thisdata->primaryKeyCollumn); //Pega todos os dados do banco de dados
        /*
         * Methodo verificar se existem dados de foreignkey */
        if (method_exists($this, 'getContentForForeignKey')) {
            $thisdata->listForeignKey = $this->getContentForForeignKey($thisdata->listRegister);
        }

        /*
         * Methodo Checa e trata dados antes de carregar a página */
        if (method_exists($this, 'checkDataBeforeLoad')) {
            $thisdata->listRegister = $this->checkDataBeforeLoad($thisdata->listRegister);
        }

        //Criação da URL para Editar
        $collumPrimarykay = $thisdata->primaryKeyCollumn;
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link . '/toedit/' . $thisdata->listRegister[0]->$collumPrimarykay;

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.customization')->with('thisdata', $thisdata);
    }

    public function editCustomizationChat($id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key
        $thisdata->listRegister = $this->getRegisterforEdit($id, "id_solicitation"); //Pega todos os dados do banco de dados

        /*
         * Methodo verificar se existem dados de foreignkey */
        if (method_exists($this, 'getContentForForeignKey')) {
            $thisdata->listForeignKey = $this->getContentForForeignKey($thisdata->listRegister);
        }

        /*
         * Methodo Checa e trata dados antes de carregar a página */
        if (method_exists($this, 'checkDataBeforeLoad')) {
            $thisdata->listRegister = $this->checkDataBeforeLoad($thisdata->listRegister);
        }

        //Criação da URL para Editar
        $collumPrimarykay = $thisdata->primaryKeyCollumn;
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link . '/toedit/' . $thisdata->listRegister[0]->$collumPrimarykay;

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.customization')->with('thisdata', $thisdata);
    }

    /**
     * Function Insert
     * Funçao de carregamento padrão das paginas de insert
     **/
    public function newinsert()
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        //Verifica se existe methodo no controller para pegar dados de foreign key
        if (method_exists($this, 'getContentForForeignKey')) {
            $thisdata->listForeignKey = $this->getContentForForeignKey();
        }

        if (method_exists($this, 'checkDataBeforeLoadInsert')) {
            $thisdata->listRegister = $this->checkDataBeforeLoadInsert();
        }

        //Criação da URL para Insert
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link . '/create';

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.insert')->with('thisdata', $thisdata);
    }

    /**
     * Function Insert for childrem
     * Funçao de carregamento padrão das paginas de insert
     **/
    public function newinsertChildrem($idFather)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        $primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key

        // $thisdata->idfather = $this->fatherDate($idFather, $primaryKeyCollumn);    // Pega os dados de cadastro do pai do menu
        $thisdata->idfather = $idFather; // Seta Id do Pai parra passar para view

        //Verifica se existe methodo no controller para pegar dados de foreign key
        if (method_exists($this, 'getContentForForeignKey')) {
            $thisdata->listForeignKey = $this->getContentForForeignKey();
        }
        if (method_exists($this, 'checkDataBeforeLoadInsert')) {
            $thisdata->listRegister = $this->checkDataBeforeLoadInsert();
        }

        //Criação da URL para Insert
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link . '/create';

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.insert')->with('thisdata', $thisdata);
    }


    /**
     * Function Carregamento de Permissão
     * Funçao que carrega dos dados de permissao do usuario selecionado
     **/

    public function loadPermission($id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->userId = $id; //Define o id do usuário
        $thisdata->userData = DB::table('vpr_login_users')->where('id_login_user', $id)->get();
        $thisdata->userPermission = $thisdata->userData[0]->id_permission;

        /**
         * Sql que pega todos as permissões de um usuarios
         * O sql remove da listagem os menus que tiverem sido deletados e inativados
         */
        $thisdata->allPermission = DB::table('vpr_permission as permission')
            ->join('vpr_nav_group_menu as menu', 'permission.id_menu', '=', 'menu.id_nav_group_menu')
            ->join('vpr_nav_group as group', 'permission.id_group', '=', 'group.id_nav_group')
            ->select('permission.*', 'menu.name as menu', 'group.name as group')
            ->where('permission.id_user', $id)
            ->where('menu.delete', false)
            ->where('menu.status', true)
            ->where('group.delete', false)
            ->where('group.status', true)
            ->orderBy('group.id_nav_group', 'asc')
            ->orderBy('menu.name', 'asc')
            ->get();

        //Verificaçoes para listagem das permissoes
        foreach ($thisdata->allPermission as $key => $permission) {
            $qtdSelect = 0;
            if ($permission->view == 1)
                $qtdSelect++;
            if ($permission->edit == 1)
                $qtdSelect++;
            if ($permission->add == 1)
                $qtdSelect++;
            if ($permission->delete == 1)
                $qtdSelect++;
            if ($permission->upload == 1)
                $qtdSelect++;
            if ($permission->status == 1)
                $qtdSelect++;

            $selectAll = 0;
            if ($qtdSelect == 6)
                $selectAll = 1;
            $thisdata->allPermission[$key]->qtd_select = $qtdSelect;
            $thisdata->allPermission[$key]->select_all = $selectAll;
        }

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.permission')->with('thisdata', $thisdata);
    }

    public function lixeira()
    {

        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        /*
         * Função de carregamento de listagem Geral
         */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData); //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle); //Campos liberados para listagem
        $thisdata->listRegister = $this->getRegisterforTrash($thisdata->listItemsTitle); //Pega todos os dados do banco de dados
        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.listdate')->with(['thisdata' => $thisdata, 'delete' => true]);
    }

    /**
     * Ações basicas 'Insert', 'Update/Edit', 'Delete'
     * v 1.0.0
     * Vk2 Studio WEB
     * 2018-11-13
     *
     */
    public function create(Requestform $request)
    {
        $inputs = $request->except(['_token']); //Remove token de autenticação da query de verificação
        $response = new \stdClass;
        $response->status = 'true';
        $response->message = 'Cadastro inserido com sucesso!';


        //Verifica se existe methodo no controller para executar qualquer ação que se torne nescessaria
        if (method_exists($this, 'checkBeforeInsert')) {
            $inputs = $this->checkBeforeInsert($inputs);
        }

        try {
            $idInsert = $this->_model::create($inputs)->getKey();
        } catch (\Throwable $th) {
            $response->status = 'error';
            $response->message = 'Houve um erro ao salvar seu cadastro, entre em contato com administrador!';

            dump($th);
            $this->LogOccurrence('error', $this->pageConf->pageData['name']);

            return json_encode($response);
        }

        //Metodo para ser usado apos salvamento de uma informação
        if (method_exists($this, 'executeAfterCreate')) {
            $return = $this->executeAfterCreate($idInsert, $inputs);
        }

        $this->LogOccurrence('create', $this->pageConf->pageData['name']);

        return json_encode($response);
    }

    public function createChildream(Requestform $request)
    {
        $inputs = $request->except(['_token']); //Remove token de autenticação da query de verificação

        $response = new \stdClass;
        $response->status = 'true';
        $response->message = 'Cadastro inserido com sucesso!';

        //Verifica se existe methodo no controller para executar qualquer ação que se torne nescessaria
        if (method_exists($this, 'checkBeforeInsert')) {
            $inputs = $this->checkBeforeInsert($inputs);
        }

        try {
            $idInsert = $this->_model::create($inputs)->getKey();
        } catch (\Throwable $th) {
            $response->status = 'error';
            $response->message = 'Houve um erro ao salvar seu cadastro, entre em contato com administrador!';
            
            dump($th);
            $this->LogOccurrence('error', $this->pageConf->pageData['name']);

            return json_encode($response);
        }

        //Metodo para ser usado apos salvamento de uma informação
        if (method_exists($this, 'executeAfterCreate')) {
            $inputs = $this->executeAfterCreate($idInsert, $inputs);
        }

        $this->LogOccurrence('create', $this->pageConf->pageData['name']);

        return json_encode($response);
    }

    public function toedit(Requestform $request, $id)
    {
        $inputs = $request->except(['_token']); //Remove token de autenticação da query de verificação

        $this->modelId = $id;

        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key

        $response = new \stdClass;
        $response->status = 'true';
        $response->message = 'Cadastro atualizado com sucesso!';


        //Verifica se existe methodo no controller para executar qualquer ação que se torne nescessaria
        if (method_exists($this, 'checkBeforeUpdate')) {
            $inputs = $this->checkBeforeUpdate($inputs);
        }

        try {
            $this->_model::find($id)->update($inputs);
        } catch (\Throwable $th) {
            $response->status = 'error';
            $response->message = 'Houve um erro ao salvar sua alteracao, entre em contato com administrador!';
            $this->LogOccurrence('error', $this->pageConf->pageData['name']);
            dump($th);
            return json_encode($response);
        }

        $this->LogOccurrence('update', $this->pageConf->pageData['name']);

        return json_encode($response);
    }

    public function delete(Requestform $request)
    {
        $inputs = $request->except(['_token']); //Remove token de autenticação da query de verificação

        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key


        /**
         * Cria Variaveis de Resposta
         */
        $response = new \stdClass;
        $response->status = 'true';
        if (count($inputs) > 1)
            $response->message = 'Registros deletados com sucesso!';
        else
            $response->message = 'Registro deletado com sucesso!';

        /**
         * Inicia a query de exclusão dos dados
         */
        $query = $this->_model::select();
        foreach ($inputs['delete'] as $key => $del) {
            if ($key > 0)
                $query->orwhere($primaryKeyCollumn, $del['value']);
            else
                $query->where($primaryKeyCollumn, $del['value']);
        }


        try {
            $query->update(['delete' => true]);
        } catch (\Throwable $th) {
            $response->status = 'error';
            if (count($inputs) > 1) {
                $response->message = 'Erro! Registros não puderam ser deletados!';
            } else {
                $response->message = 'Erro! Registro não pode ser deletado!';
            }
            $this->LogOccurrence('error', $this->pageConf->pageData['name']);
            return json_encode($response);
        }
        $this->LogOccurrence('delete', $this->pageConf->pageData['name']);

        return json_encode($response);
    }
    public function deleteunique($id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key

        /**
         * Cria Variaveis de Resposta
         */
        $response = new \stdClass;
        $response->status = 'true';
        $response->message = 'Registros deletados com sucesso!';

        /**
         * Inicia a query de exclusão dos dados
         */
        try {
            $this->_model::find($id)->update(['delete' => true]);
        } catch (\Throwable $th) {
            $response->status = 'error';
            $response->message = 'Erro! Registros não puderam ser deletados!';
            $this->LogOccurrence('error', $this->pageConf->pageData['name']);

            return json_encode($response);
        }

        $this->LogOccurrence('delete', $this->pageConf->pageData['name']);

        return json_encode($response);

    }

    public function restore(Requestform $request)
    {
        $inputs = $request->except(['_token']); //Remove token de autenticação da query de verificação

        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key


        /**
         * Cria Variaveis de Resposta
         */
        $response = new \stdClass;
        $response->status = 'true';
        if (count($inputs) > 1)
            $response->message = 'Registros restaurados com sucesso!';
        else
            $response->message = 'Registro restaurados com sucesso!';

        /**
         * Inicia a query de exclusão dos dados
         */
        $query = $this->_model::select();

        foreach ($inputs['delete'] as $key => $del) {
            if ($key > 0)
                $query->orwhere($primaryKeyCollumn, $del['value']);
            else
                $query->where($primaryKeyCollumn, $del['value']);
        }

        if (!$query->update(['delete' => false])) {
            $response->status = 'error';
            if (count($inputs) > 1)
                $response->message = 'Erro! Registros não puderam ser restaurados!';
            else
                $response->message = 'Erro! Registro não pode ser restaurado!';
        }
        echo json_encode($response);

    }


    /**
     * Função ESPECIFICA DE UPLOAD DE AQUIVOS
     * v 1.0.0
     * Vk2 Studio WEB
     * 2020-01-29
     *
     */
    public function formfilesupload($idFather)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento

        $primaryKeyCollumn = $this->getPrimaryKey($thisdata->pageConf->pageData); //pega primary Key

        // $thisdata->idfather = $this->fatherDate($idFather, $primaryKeyCollumn);    // Pega os dados de cadastro do pai do menu
        $thisdata->idfather = $idFather; // Seta Id do Pai parra passar para view

        //Verifica se existe methodo no controller para pegar dados de foreign key
        if (method_exists($this, 'getContentForForeignKey')) {
            $thisdata->listForeignKey = $this->getContentForForeignKey();
        }
        if (method_exists($this, 'checkDataBeforeLoadInsert')) {
            $thisdata->listRegister = $this->checkDataBeforeLoadInsert();
        }

        //Criação da URL para Insert
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link . '/filesupload';

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.insert')->with('thisdata', $thisdata);
    }

    /**
     * Saving files uploaded through XHR Request.
     * The file storage path is defined has folllows:
     * Storage Disk path + folder name in md5 + ID of the register in md5 + file original name in Laravel custom cryptography.
     * Once successfully saved, if the optional parameter $model has been set
     * it saves the upload register in the model table and returns Bolean true on success, if not set it returns the file name.
     * On error return Bolean false.
     * @var String $disk_name
     * @var \Illuminate\Http\UploadedFile $file
     * @var Integer $id
     * @var String $folder_name
     * @var Illuminate\Database\Eloquent\Model $model
     * @return Boolean
     * @return String
     */
    public function storeFile($disk_name, $folder_name, $id, $file, $model = null)
    {
        // Generate the storage path
        $storePath = md5($folder_name) . '/' . md5($id);
        // Atempt to save file
        try {
            $savedPath = Storage::disk($disk_name)->putFile($storePath, $file, 'public');
            // Gets the file generated name
            preg_match("/[^\/]+$/", $savedPath, $matches);
            $filename = $matches[0];

            // If $model is set them attempt to save
            if ($model != null) {
                $file_data = new $model;
                $file_data->id_file = $id;
                $file_data->name = $filename;
                $file_data->original_name = $file->getClientOriginalName();
                $file_data->extension = $file->getClientOriginalExtension();
                $file_data->save();

                return true;
            } else {
                return $filename;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Retrieve file URL path from storage disks.
     * If file is found return the path in String, else return Boolean false
     * @var String $disk_name
     * @var String $folder_name
     * @var Integer $id
     * @var String $file_name
     * @return Boolean
     * @return String
     */
    public function getFileURL($disk_name, $folder_name, $id, $file_name)
    {
        // Generate the storage path
        $storePath = md5($folder_name) . '/' . md5($id);

        // Check if file exists
        if (Storage::disk($disk_name)->exists($storePath . '/' . $file_name))
            return Storage::disk($disk_name)->url($storePath . '/' . $file_name);
        else
            return false;
    }

    /**
     *
     *
     * @var String $disk_name
     * @var String $folder_name
     * @var Integer $id
     * @var String $file_name
     * @var Illuminate\Database\Eloquent\Model $model
     * @return Boolean
     * @return String
     */
    public function removeFile($disk_name, $folder_name, $bound_id, $id, $model = null)
    {
        // Generate the storage path
        $storePath = md5($folder_name) . '/' . md5($bound_id);

        // Attemp to get the file enrty from the database
        $db_file = $model::find($id);
        if ($db_file == null) {
            return false;
        }

        // Check if file exists
        if (Storage::disk($disk_name)->exists($storePath . '/' . $db_file->name)) {
            // Remove from database and form filesystem
            $db_file->delete = true;
            $db_file->save();
            Storage::disk($disk_name)->delete($storePath . '/' . $db_file->name);
            return true;
        } else {
            return false;
        }
    }

    // File mimetype validations
    public function fileMimeValidate($file, array $valid_mimetypes)
    {
        $filevar = new \stdClass;
        $filevar->mimeType = $file->getMimeType();

        foreach ($valid_mimetypes as $mimetype) {
            if ($filevar->mimeType == $mimetype)
                return true;
        }
        return false;
    }

    public function getOriginIndex()
    {
        $request = app('request')->route()->getAction();

        $root = explode('@', $request['controller'])[0];

        $root = substr(str_replace($request['namespace'], '', $root), 1);

        $action = $root . '@index';

        if ($this->pageConf->pageFather != "null") {
            $action = $root . '@indexchildrem';
            $parameters = array('id' => $this->idRegisterselect);

            return action($action, $parameters);
        }

        return action($action);
    }

    function getClientIP()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function LogOccurrence(string $action, string $page, string $channel = null): void
    {
        if (empty($channel)) {
            $channel = 'actions';
        }

        $requestData = collect(app('request')->request)->except('_token');


        switch ($action) {
            case 'create':
                $infoMessage = "Novo Cadastro de {$page} \n";
                break;
            case 'update':
                $infoMessage = "Atualização de {$page} \n";
                $requestData->prepend($this->modelId, 'id');
                break;
            case 'delete':
                $infoMessage = "Cadastro de {$page} deletado \n";
                break;
            case 'error':
                $infoMessage = "Erro no cadastro de {$page} \n";
                break;
            default:
                $infoMessage = "Evento no cadastro de {$page} \n";
                break;
        }


        if ($requestData->has('description')) {
            $requestData['description'] = strip_tags($requestData['description']);
        }

        if ($action == 'delete' && $requestData->has('delete')) {
            $affectedIds = [];
            foreach ($requestData['delete'] as $deletedItem) {
                $affectedIds[] = intval($deletedItem['value']);
            }

            $requestData = implode(',', $affectedIds);
        }

        $info = [
            'user' => collect(auth()->user()::get()->first())->pull('name'),
            'userIp' => $this->getClientIP(),
            'página' => $page ?? null,
            'dados afetados' => $requestData,
        ];

        foreach ($info as $key => $value) {
            $value = is_array($value) ? json_encode($value) : $value;
            $infoMessage .= json_encode([$key => $value], JSON_UNESCAPED_UNICODE) . " \n";
        }
        Log::channel($channel)->info($infoMessage);
    }

    public function deleteNotification(Requestform $request)
    {
        $request = $request->toArray();
        try {
            if (isset($request['id'])) {
                \App\Models\Admin\Notification::where('id_notification', $request['id'])->update([
                    'read' => true
                ]);
            } else if (isset($request['readAll'])) {
                \App\Models\Admin\Notification::where('id_user', Auth::user()->id_login_user)->update([
                    'read' => true
                ]);
            }

        } catch (\Throwable $th) {
            Log::error($th);
            return json_encode(['status' => 'error']);
        }


        return json_encode(
            [
                'status' => 'success',
                'notificationCount' => \App\Models\Admin\Notification::where('read', false)
                    ->where('id_user', Auth::user()->id_login_user)
                    ->get()->count()
            ]
        );
    }

}