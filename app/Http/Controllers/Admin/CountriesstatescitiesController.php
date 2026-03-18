<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Countriesstatescities;
use Illuminate\Http\Request;
use DB;

class CountriesstatescitiesController extends Controller
{
    public function __construct()
    {
        $this->_model = Countriesstatescities::class;                                       // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "countriesstates";                                    //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "id_state";                                      //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function get_id_state($register){
        $state = DB::table('vpr_countries_states')->where('id_state', $register->id_state)->get();
        return $state[0]->name;
    }


    public function checkBeforeInsert($register)
    {
        return $register;
    }

    public function checkDataBeforeLoad($register)
    {
        return $register;
    }

    public function getContentForForeignKey()
    {
        $this->foreingKey = new \stdClass;
        
        $states = DB::table('vpr_countries_states')->select('name', 'id_state as id')->where('status', true)->pluck('name', 'id');

        $this->foreingKey->state = collect($states)->toArray();
        
        return $this->foreingKey;
    }
}
