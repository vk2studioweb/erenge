<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Countries;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function __construct()
    {
        $this->_model = Countries::class;                                       // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null";                                    //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "";                                      //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }
}
