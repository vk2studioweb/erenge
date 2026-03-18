<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Configuration;
use Illuminate\Http\Request;
use DB;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        // Declaração do Model da página
        $this->_model = Configuration::class;                                                  
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
    /*  
    / Funções get_[nome da coluna] executam de acordo com colunas com func ativado na listagem
    / $register -> Collection
    */     
    // public function get_[nome da coluna]($register)
    // {
    //     return $register;
    // }

    /*  
    / Executa antes de carregar o conteudo de um item da listagem
    / $register -> Collection
    */   
    public function checkDataBeforeLoad($register){
        return $register;
    }

    /*  
    / Executa antes de inserir novo item da listagem
    / $register -> array
    */  
    public function checkBeforeInsert($register){
        return $register;
    }
    /*  
    / Executa antes de autalizar item da listagem
    / $register -> array
    */ 
    public function checkBeforeUpdate($register){
        return $register;
    }

    /*  
    / Executa antes de exibir item da listagem, para recolher dados extrangeiros
    */
    public function getContentForForeignKey(){        
        $this->foreingKey = new \stdClass;
    
        // Get your stuff here
    
        return $this->foreingKey;
    }
}