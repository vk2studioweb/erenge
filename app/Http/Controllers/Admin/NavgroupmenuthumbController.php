<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroupmenuthumb;
use Illuminate\Http\Request;
use DB;

class NavgroupmenuthumbController extends Controller
{
    public function __construct()
    {
        $this->_model = Navgroupmenuthumb::class;                                     // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "navgroupmenu";                                     //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "id_menu";                                         //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }


}
