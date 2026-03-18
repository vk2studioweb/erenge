<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\Obras;
use Illuminate\Support\Carbon;
use DB;


class ObrasController extends Controller
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

    public function getObras(){
        $obras = Obras::where('status', 1)->where('delete', 0)->paginate(1);
        $obras = $this->getUploadListArray(18, $obras, 'id_obra');
        return $obras;
    }

    public function index() {
        
        $this->pageData->obras = $this->getObras();
        $this->pageData->page = "Obras";
        
        return view('Site.obras')->with('thisdata', $this->pageData);
    }

    public function getObra($id){
        $obras = Obras::where('id_obra', $id)->where('status', 1)->where('delete', 0)->get();
        $obras = $this->getUploadListArray(18, $obras, 'id_obra');
        return $obras->first();
    }

    public function show ($slug, $id) {
        
        $this->pageData->obra = $this->getObra($id);
        $this->pageData->page = "Obras";
        
        return view('Site.obra')->with('thisdata', $this->pageData);
    }
}
