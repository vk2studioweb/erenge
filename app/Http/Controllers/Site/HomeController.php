<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\Banners;
use App\Models\Admin\Servicos;
use App\Models\Admin\Obras;
use App\Models\Admin\Noticias;
use Illuminate\Support\Carbon;
use DB;


class HomeController extends Controller
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

    public function getBanners()
    {
        $result = Banners::where('status', true)->where('delete', false)->orderBy('order', 'asc')->get();
        $result = $this->getUploadListArray(14, $result, 'id_banner');
        return $result;
    }

    public function getServicos()
    {
        $result = Servicos::where('status', true)->where('delete', false)->orderBy('order', 'asc')->get();
        $result = $this->getUploadListArray(17, $result, 'id_servico');
        return $result;
    }

    public function getObras()
    {
        $result = Obras::where('status', true)->where('delete', false)->orderBy('id_obra', 'desc')->limit(3)->get();
        $result = $this->getUploadListArray(18, $result, 'id_obra');
        return $result;
    }

    public function getNoticias()
    {
        $result = Noticias::where('status', true)->where('delete', false)->orderBy('id_noticia', 'desc')->limit(3)->get();
        $result = $this->getUploadListArray(23, $result, 'id_noticia');
        return $result;
    }

    public function index() {
        
        $this->pageData->banners = $this->getBanners();
        $this->pageData->servicos = $this->getServicos();
        $this->pageData->obras = $this->getObras();
        $this->pageData->noticias = $this->getNoticias();
        
        return view('Site.home')->with('thisdata', $this->pageData);
    }
}
