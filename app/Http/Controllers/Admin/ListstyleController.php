<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Liststyle;
use Illuminate\Http\Request;

class ListstyleController extends Controller
{

    public function __construct()
    {
        $this->_model = Liststyle::class;    // Declaração do Model da página
        
        $pageConf = new \stdClass; //Inicia objeto com dados da pag.
        
        $pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $pageConf->pageFather = "null";                                             //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        $pageConf->listStyle = $this->getListStyle($pageConf->pageData);            //pega Configuraçoes de stilo de listagem
        $pageConf->listItems = $this->getItemsforList($pageConf->listStyle);        //Campos liberados para listagem
        $pageConf->search = $this->getListStyle();                                  //Habilita campos de busca
        $this->pageConf = $pageConf;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Liststyle  $liststyle
     * @return \Illuminate\Http\Response
     */
    public function show(Liststyle $liststyle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Liststyle  $liststyle
     * @return \Illuminate\Http\Response
     */
    public function edit(Liststyle $liststyle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Liststyle  $liststyle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liststyle $liststyle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Liststyle  $liststyle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liststyle $liststyle)
    {
        //
    }
}
