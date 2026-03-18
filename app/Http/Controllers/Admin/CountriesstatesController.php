<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Countries;
use App\Models\Admin\Countriesstates;
use Illuminate\Http\Request;

class CountriesstatesController extends Controller
{
    public function __construct()
    {
        $this->_model = Countriesstates::class;                                       // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null";                                    //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "";                                      //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }
    public function get_id_country($register){
        $country = Countries::find($register->id_country);
        return $country->name;
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

        $countries = Countries::select('name', 'id_country as id')->where('status', true)->pluck('name', 'id');
        $this->foreingKey->countries = collect($countries)->toArray();

        return $this->foreingKey;
    }
}
