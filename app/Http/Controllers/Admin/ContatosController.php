<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Contatos;
use Illuminate\Http\Request;
use DB;

class ContatosController extends Controller
{
    public function __construct()
    {
        $this->_model = Contatos::class;

        $this->pageConf = new \stdClass;
        $this->pageConf->pageData       = $this->getPageData();
        $this->pageConf->pageFather     = "null";
        $this->pageConf->collunIdFather = "null";
        $this->pageConf->pageChildren   = $this->getPageChildren();
    }
}
