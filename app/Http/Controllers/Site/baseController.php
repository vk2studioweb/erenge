<?php

namespace App\Http\Controllers\Site;

use App\Models\Admin\Configuration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datetime;
use DB;
use Illuminate\Support\Facades\Route;

class baseController extends Controller
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
        $this->pageData->header = $this->getHeader();
        $this->pageData->footer = $this->getFooter();
        $this->pageData->language = app()->getLocale();
        $this->pageData->whatsapp  = $this->getWhatsapp();
    }
    public function index()
    {
        $this->pageData->config->name .= " - ".__("site.company");
        return view('Site.home')->with('thisdata', $this->pageData);
    }
}
