<?php

namespace App\Http\Controllers\Site;

use App\Models\Admin\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class NewsController extends Controller
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
        $this->pageData->internalBanners = $this->getInternalBanners('noticias');
    }

    public function getNews($paginate)
    {
        $result = News::where('status', 1)->where('delete', 0)->paginate($paginate);
        $result = $this->getUploadListArray(18, $result, 'id_news');
        return $result;
    }

    public function getNewsZoom($id)
    {
        $result = News::where('id_news', $id)->where('status', 1)->where('delete', 0)->get();
        if(!$result->isEmpty()){
            $result = $this->getUploadListArray(18, $result, 'id_news');
            $result = $this->setFormateDate($result); 
        }
        return $result;
    }

    public function getOtherNews($id)
    {
        $result = News::where('id_news', '!=', $id)->where('status', 1)->where('delete', 0)->get();
        $result = $this->getUploadListArray(18, $result, 'id_news');
        return $result;
    }

    public function index()
    {
        $this->pageData->news = $this->getNews(9);
        return view('Site.noticias')->with('thisdata', $this->pageData);
    }
    
    public function zoom($name, $id)
    {
        $news = $this->getNewsZoom($id);
        if($news != null){
            $this->pageData->news = $news->first();
            $this->pageData->newsOther = $this->getOtherNews($id);
            return view('Site.noticia')->with('thisdata', $this->pageData);
        }
        return view('Site.404')->with('thisdata', $this->pageData);
    }

}
