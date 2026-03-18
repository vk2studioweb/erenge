<?php

namespace App\Http\Controllers\Site;

use App\Models\Admin\Business;
use App\Models\Admin\Textbusiness;
use App\Models\Admin\Businessvalues;
use App\Models\Admin\Businessvideo;
use App\Models\Admin\Certificates;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class BusinessController extends Controller
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
        $this->pageData->business = $this->getBusiness();
        $this->pageData->internalBanners = $this->getInternalBanners('empresa');
    }

    public function getTextBusiness(){
        $return = Textbusiness::where('status', true)->where('delete', false)->get();
        if(!$return->isEmpty()){
            $return = $this->getUploadListArray(25, $return, 'id_textbusiness');
            $return = $return->groupBy('info_location');
        }
        return $return;
    }
    public function getBusinessvideo(){
        $return = Businessvideo::where('status', true)->where('delete', false)->get();
        return $return;
    }
    public function getBusinessvalues(){
        $return = Businessvalues::where('status', true)->where('delete', false)->get();
        if(!$return->isEmpty()){
            $return = $this->getUploadListArray(36, $return, 'id_businessvalues');
        }
        return $return;
    }
    public function getcertificates(){
        $return = Certificates::where('status', true)->where('delete', false)->get();
        if(!$return->isEmpty()){
            $return = $this->getUploadListArray(37, $return, 'id_certificate');
        }
        return $return;
    }


    public function index()
    {
        $this->pageData->textbusiness = $this->getTextBusiness();
        $this->pageData->video = $this->getBusinessvideo();
        $this->pageData->values = $this->getBusinessvalues();
        $this->pageData->certificates = $this->getcertificates();

        return view('Site.empresa')->with('thisdata', $this->pageData);
    }

}
