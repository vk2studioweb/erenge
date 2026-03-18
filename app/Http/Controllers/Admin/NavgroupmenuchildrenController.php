<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroupmenuchildren;
use Illuminate\Http\Request;
use DB;

class NavgroupmenuchildrenController extends Controller
{
    public function __construct()
    {
        $this->_model = Navgroupmenuchildren::class;                                     // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "navgroupmenu";                                     //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "id_menu";                                         //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function getRadioCorrect($register)
    {
        $register[0]->opcao1 = ($register[0]->default == 1) ? true : false;
        $register[0]->opcao2 = ($register[0]->default == 0) ? true : false;
        return $register;
    }

    public function checkDataBeforeLoad($register)
    {
        //função para teste
        $register = $this->getRadioCorrect($register);
        
        return $register;
    }

}
