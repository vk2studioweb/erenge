<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Filiais;
use Illuminate\Http\Request;
use DB;

class FiliaisController extends Controller
{
    public function __construct()
    {
        $this->_model = Filiais::class;

        $this->pageConf = new \stdClass;
        $this->pageConf->pageData       = $this->getPageData();
        $this->pageConf->pageFather     = "null";
        $this->pageConf->collunIdFather = "null";
        $this->pageConf->pageChildren   = $this->getPageChildren();
    }
}
