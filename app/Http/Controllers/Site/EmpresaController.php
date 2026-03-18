<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\TextBusiness;
use Illuminate\Support\Carbon;
use DB;


class EmpresaController extends Controller
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

    public function getTextsBusiness(){
        $texts = TextBusiness::where('status', 1)->where('delete', 0)->get();
        $texts = $this->getUploadListArray(13, $texts, 'id_textbusiness');
        if(!empty($texts)){
            $texts = $texts->groupBy('info_location');
            return $texts;
        }
        return "";
    }

    public function index() {
        
        $this->pageData->textbusiness = $this->getTextsBusiness();
        $this->pageData->page = "Empresa";
        
        return view('Site.empresa')->with('thisdata', $this->pageData);
    }
}
