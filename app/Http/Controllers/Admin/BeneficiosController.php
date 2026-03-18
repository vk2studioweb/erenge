<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Beneficios;
use Illuminate\Http\Request;
use DB;

class BeneficiosController extends Controller
{
    public function __construct()
    {
        $this->_model = Beneficios::class;

        $this->pageConf = new \stdClass;
        $this->pageConf->pageData       = $this->getPageData();
        $this->pageConf->pageFather     = "null";
        $this->pageConf->collunIdFather = "null";
        $this->pageConf->pageChildren   = $this->getPageChildren();
    }
}
