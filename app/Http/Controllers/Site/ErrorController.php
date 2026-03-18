<?php

namespace App\Http\Controllers\Site;
use DB;

class ErrorController extends Controller {
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct() {
        $this->pageData           = new \stdClass;
        $this->pageData->config   = $this->getConfig();
        $this->pageData->texts    = $this->getTexts();
        $this->pageData->networks = $this->getNetworks();
        $this->pageData->business = $this->getBusiness();
        $this->pageData->endereco = $this->getAddress();
        $this->pageData->termos = $this->getTerms();
        $this->pageData->whatsapp  = $this->getWhatsapp();
    }

    public function index() {
        $this->pageData->banner = $this->getInternalBanners('404');
        return view('Site.404')->with('thisdata', $this->pageData);
    }
    
}
