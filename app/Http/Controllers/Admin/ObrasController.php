<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Obras;
use App\Models\Admin\Servicos;
use Illuminate\Http\Request;
use DB;

class ObrasController extends Controller
{
    public function __construct()
    {
        $this->_model = Obras::class;

        $this->pageConf = new \stdClass;
        $this->pageConf->pageData       = $this->getPageData();
        $this->pageConf->pageFather     = "null";
        $this->pageConf->collunIdFather = "null";
        $this->pageConf->pageChildren   = $this->getPageChildren();
    }

    public function getContentForForeignKey()
    {
        $this->foreingKey = new \stdClass;
        
        $servicos = Servicos::select('nome as name', 'id_servico as id')->where('status', true)->pluck('name', 'id');

        $this->foreingKey->servicos = collect($servicos)->toArray();
        
        return $this->foreingKey;
    }

}
