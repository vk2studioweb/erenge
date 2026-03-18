<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroupmenustylecollumn;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\URL;

class NavgroupmenustylecollumnController extends Controller
{
    public function __construct()
    {
        $this->_model = Navgroupmenustylecollumn::class;                                     // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "navmenustyle";                                     //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->collunIdFather = "id_menu_style";                                         //Chave Estrangeira do pai para criar SQL
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function loadcollumn($idStyle)
    {

        $thisdata = new \stdClass;                           // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf;               //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->idStyle = $idStyle;
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link;

        /*
        * Função de carregamento de listagem Geral */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData);           //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle);            //Campos liberados para listagem
        
        /**
         * Pega todos os registros das collunas de cada estylo */
        $thisdata->collumns = $this->_model::where($thisdata->pageConf->collunIdFather, $idStyle)->where('delete', false)->get();


        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.menustylecollumn')->with('thisdata', $thisdata);
    }

    public function editcollumn($idStyleCollumn)
    {
        $thisdata = new \stdClass;                           // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf;               //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->idStyleCollumn = $idStyleCollumn;
        $thisdata->url = URL::to('/admin/') . '/' . $thisdata->pageConf->pageData->link;

        /*
        * Função de carregamento de listagem Geral */
        $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData);           //pega Configuraçoes de stilo de listagem
        $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle);            //Campos liberados para listagem
        
        /**
         * Pegar os registros da coluna selecionada */
        $thisdata->listRegister = $this->_model::where('id_menu_style_list', $idStyleCollumn)->get();
        $idStyle = $thisdata->listRegister[0]->id_menu_style;
        /**
         * Pega todos os registros das collunas de cada estylo */
        $thisdata->collumns = $this->_model::where($thisdata->pageConf->collunIdFather, $idStyle)->where('id_menu_style_list', '<>', $idStyleCollumn)->where('delete', false)->get();


        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.menustylecollumn')->with('thisdata', $thisdata);
    }


    public function deletecollumn(Request $request)
    {
        //Remove token de autenticação da query de verificação
        $inputs = $request->except(['_token']);
        
        $response = new \stdClass;
        $response->status = 'true';
        $response->message = 'Cadastro removido com sucesso!';
        

        if(!$this->_model::where('id_menu_style_list', $inputs['idCollumnStyle'])->update(['delete'=>true]))
        {
            $response->status = 'false';
            $response->message = 'Erro Inesperado, não foi possivel deletar o dado solicitado!';
        }
        
        echo json_encode($response);
    }

    public function updatecollumn(Request $request)
    {
        //Remove token de autenticação da query de verificação
        $inputs = $request->except(['_token']);
        
        $response = new \stdClass;
        $response->status = 'true';
        $response->message = 'Cadastro atualizado com sucesso!';
        $response->idStyle = $request['id_menu_style'];

        if(!$this->_model::where('id_menu_style_list', $inputs['id_menu_style_list'])->update($inputs))
        {
            $response->status = 'false';
            $response->message = 'Erro Inesperado, não foi possivel atualizar o dado solicitado!';
        }
        
        echo json_encode($response);
    }

    public function insertcollumn(Request $request)
    {
        //Remove token de autenticação da query de verificação
        $inputs = $request->except(['_token']);
        
        $response = new \stdClass;
        $response->status = 'false';
        $response->message = 'Erro Inesperado, não foi possivel inserir o dado solicitado!';
        
        if($idInsert = $this->_model::insertGetId($inputs))
        {
            $response->status = 'true';
            $response->message = 'Cadastro inserido com sucesso!';
            $response->idStyle = $idInsert;
        }
        
        echo json_encode($response);
    }

}
