<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Servicos;
use Illuminate\Http\Request;
use DB;

class ServicosController extends Controller
{
    public function __construct()
    {
        $this->_model = Servicos::class;

        $this->pageConf = new \stdClass;
        $this->pageConf->pageData       = $this->getPageData();
        $this->pageConf->pageFather     = "null";
        $this->pageConf->collunIdFather = "null";
        $this->pageConf->pageChildren   = $this->getPageChildren();
    }
}
