<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroupmenustyle;
use Illuminate\Http\Request;
use DB;

class NavgroupmenustyleController extends Controller
{
    public function __construct()
    {
        $this->_model = Navgroupmenustyle::class;                                         // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "navgroupmenu";                                     //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "id_menu";                                      //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function get_default($line)
    {
        if($line->default == 0) return 'Não';
        if($line->default == 1) return 'Sim';
    }
    
    public function get_id_style($line)
    {
        $style = DB::table('vpr_list_style')->where('id_style', $line->id_style)->get();
        return $style[0]->name;
    }


    public function getContentForForeignKey()
    {
        $this->foreingKey = new \stdClass;

        $style = DB::table('vpr_list_style')->select('name', 'id_style as id')->where('id_style', '<>', 4)->where('status', true)->where('delete', false)->orderBy('id_style', 'asc')->pluck('name', 'id');
        $this->foreingKey->style = ['0' => 'Selecione'] + collect($style)->toArray();

        return $this->foreingKey;
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
