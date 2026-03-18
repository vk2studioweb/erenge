<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\Servicos;
use App\Models\Admin\Obras;
use Illuminate\Support\Carbon;
use DB;


class ServicosController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->pageData = new \stdClass;
        $this->pageData->config = $this->getConfig();
        $this->pageData->texts = $this->getTexts();
        $this->pageData->networks = $this->getNetworks();
        $this->pageData->termos = $this->getTerms();
        $this->pageData->whatsapp = $this->getWhatsapp($this->pageData->networks);
        $this->pageData->address = $this->getAddress();
    }

    public function getServices(){
        $servicos = Servicos::where('status', 1)->where('delete', 0)->get();
        $servicos = $this->getUploadListArray(17, $servicos, 'id_servico');
        return $servicos;
    }

    public function index() {
        
        $this->pageData->servicos = $this->getServices();
        $this->pageData->page = "Serviços";
        
        return view('Site.servicos')->with('thisdata', $this->pageData);
    }

    public function getService($id){
        $servicos = Servicos::where('id_servico', $id)->where('status', 1)->where('delete', 0)->get();
        $servicos = $this->getUploadListArray(17, $servicos, 'id_servico');
        return $servicos->first();
    }
    public function getObras($id){
        $Obras = Obras::where('servico_id', $id)->where('status', 1)->where('delete', 0)->orderBy('id_obra', 'desc')->limit(3)->get();
        $Obras = $this->getUploadListArray(18, $Obras, 'id_obra');
        return $Obras;
    }

    public function show ($slug, $id) {
        
        $this->pageData->servico = $this->getService($id);
        $this->pageData->obras = $this->getObras($id);
        $this->pageData->page = "Serviços";
        
        return view('Site.servico')->with('thisdata', $this->pageData);
    }
}
