<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroup;
use Illuminate\Http\Request;
use DB;

class NavgroupController extends Controller
{
    public function __construct()
    {   
        // Declaração do Model da página
        $this->_model = Navgroup::class;                                                  
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

    public function getRadioCorrect($register)
    {
        $register[0]->opcao1 = ($register[0]->submenu == 1) ? true : false;
        $register[0]->opcao2 = ($register[0]->submenu == 0) ? true : false;
        return $register;
    }

    public function checkDataBeforeLoad($register)
    {
        //função para teste
        $register = $this->getRadioCorrect($register);
        return $register;
    }


    //Method para Pegar dados da chave estrangeira
    public function getDataForeignKey()
    {
        $this->thisData = new \stdClass;
        $this->thisData->categorias = DB::table('vpr_nav_group')->get();
        return $this->thisData;
    }

}
