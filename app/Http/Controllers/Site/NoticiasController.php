<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\Noticias;
use Illuminate\Support\Carbon;
use DB;


class NoticiasController extends Controller
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

    public function getNoticias(){
        $noticias = Noticias::where('status', 1)->where('delete', 0)->paginate(12);
        $noticias = $this->getUploadListArray(23, $noticias, 'id_noticia');
        return $noticias;
    }

    public function index() {
        
        $this->pageData->noticias = $this->getNoticias();
        $this->pageData->page = "Novidades";
        
        return view('Site.noticias')->with('thisdata', $this->pageData);
    }

    public function getNoticia($id){
        $noticia = Noticias::where('id_noticia', $id)->where('status', 1)->where('delete', 0)->get();
        $noticia = $this->getUploadListArray(23, $noticia, 'id_noticia');
        return $noticia->first();
    }
    public function getOtherNoticia($id){
        $noticias = Noticias::where('id_noticia', '!=', $id)->where('status', 1)->where('delete', 0)->limit(3)->orderBy('id_noticia', 'desc')->get();
        $noticias = $this->getUploadListArray(23, $noticias, 'id_noticia');
        return $noticias;
    }

    public function show ($slug, $id) {
        
        $this->pageData->noticia = $this->getNoticia($id);
        $this->pageData->maisNoticias = $this->getOtherNoticia($id);
        $this->pageData->page = "Novidades";
        
        return view('Site.noticia')->with('thisdata', $this->pageData);
    }
}
