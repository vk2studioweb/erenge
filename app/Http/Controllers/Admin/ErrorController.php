<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;


class ErrorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_model = Navgroup::class;                                                  // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null";                                             //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    // public function getPageData()
    // {
    //     $navGroupMenu[0] = new \stdClass;
    //     $navGroupMenu[0]->id_nav_group_menu = 0;
    //     $navGroupMenu[0]->id_group = 0;
    //     $navGroupMenu[0]->name = "error";
    //     $navGroupMenu[0]->link = 'error';
        
    //     return $navGroupMenu[0];
    // }
    
    
    // public function getItemsforList($listStyle)
    // {
    //     //Definição de objeto padrao que irá conter os itens a serem carregados em cada listagem 
    //     $itemsOpen = new \stdClass;
        
    //     if($listStyle == 1)
    //     {}
    //     else if($listStyle == 2)
    //     {}
    //     else if($listStyle == 3)
    //     {}
        
    //     return $itemsOpen;
    // }
    
    public function errorList()
    {
        $thisdata = new \stdClass;
        if(Request::segment(3) == 'permission'){
            $thisdata->error = "Acesso negado";
            $thisdata->errorPage = "Admin/Errors/denied";
            $thisdata->pageConf = $this->pageConf;
            return view('Admin.error')->with('thisdata', $thisdata);
        }
    }

}
