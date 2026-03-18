<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\Polices;

class TermosController extends Controller {
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct() {
        $this->pageData = new \stdClass;
        $this->pageData->config = $this->getConfig();
        $this->pageData->texts = $this->getTexts();
        $this->pageData->networks = $this->getNetworks();
        $this->pageData->termos = $this->getTerms();
        $this->pageData->whatsapp = $this->getWhatsapp($this->pageData->networks);
        $this->pageData->address = $this->getAddress();
        $this->pageData->page = "Termos";
    }
    
    public function getTerm($slug)
    {
        $return = Polices::where('slug', $slug)->where('status', true)->where('delete', false)->get();
        return $return;
    }

    public function index($slug) {
        
        $this->pageData->terms    = $this->getTerm($slug);
        if($this->pageData->terms->count() > 0){
            return view('Site.terms')->with('thisdata', $this->pageData);
        } else{
            return view('Site.404')->with('thisdata', $this->pageData);
        }
        
    }
    
}
