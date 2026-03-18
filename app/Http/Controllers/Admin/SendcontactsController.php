<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Departaments;
use App\Models\Admin\Sendcontacts;
use Illuminate\Http\Request;
use DB;

class SendcontactsController extends Controller
{
    public function __construct()
    {
        // Declaração do Model da página
        $this->_model = Sendcontacts::class;                                                  
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
    public function get_id_departament($register)
    {
        $dep = Departaments::find($register->id_departament);
        $register->id_departament = $dep->name;
        return $register;
    }
    public function checkDataBeforeLoad($var)
    {
        $dep = Departaments::find($var[0]->id_departament);
        $var[0]->departament = $dep->name;
        return $var;
    }
}
