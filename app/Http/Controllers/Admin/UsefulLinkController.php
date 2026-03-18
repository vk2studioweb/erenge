<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Configuration;
use App\Models\Admin\UsefulLink;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datetime;
use DB;
use Illuminate\Support\Facades\Route;

class UsefulLinkController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        // Declaração do Model da página
        $this->_model = UsefulLink::class;                                                  
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
