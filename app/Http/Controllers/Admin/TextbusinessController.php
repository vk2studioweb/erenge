<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Textbusiness;
use Illuminate\Http\Request;
use DB;

class TextbusinessController extends Controller
{
    public function __construct()
    {
        // Declaração do Model da página
        $this->_model = Textbusiness::class;                                                  
        //Inicia objeto com dados da pag.
        $this->pageConf = new \stdClass;                                                  
        //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageData = $this->getPageData();                                 
        //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageFather = "null";                                             
        //Chave Estrangeira do pai para criar SQL
        $this->pageConf->collunIdFather = "[id_do_pai]";                                      
        //Pega o submenu de cadastro
        $this->pageConf->pageChildren = $this->getPageChildren();                         
    }
}
