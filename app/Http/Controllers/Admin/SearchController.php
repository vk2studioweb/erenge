<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;

class SearchController extends Controller
{
    public function __construct()
    {
                                                
    }
    
    // Receive model and search term then execute search
    public function search($model_name, Request $request, $father_id = null){
      // First we set default values that Julio uses for the page loading
      // Variable that is passed to view
      $thisdata = new \stdClass;
      
      // Construct the full model path, since we are Admin we always use Admin models
      $this->_model = "App\Models\Admin\\" . ucfirst($model_name);    
      // Page configuration data
      $this->pageConf = new \stdClass;  
      $this->pageConf->pageFather = (new $this->_model)->father_page;
      $this->pageConf->collunIdFather = (new $this->_model)->father_column;      
      $this->pageConf->pageData = $this->getPageData();
      $this->pageConf->pageFather = "";
      $this->pageConf->pageChildren = $this->getPageChildren();   
      $thisdata->pageConf = $this->pageConf;     
      // Loads List styles configurations
      $thisdata->listStyle = $this->getListStyle($thisdata->pageConf->pageData);
      // Loads List coluns configurations
      $thisdata->listItemsTitle = $this->getTitleforList($thisdata->listStyle);
      
      // Loads List Order configuration
      $configSelect = $this->getOrderSelect($thisdata->listItemsTitle);

      // Retrieve inputs from request
      $inputs = $request->except(['_token']);

      // Retrieve the model table name
      $model_fillables = (new $this->_model())->getFillable();

      // Create a query to search for the term
      $query = $this->_model::query();
      // One where for each column
      foreach($model_fillables as $column){
          $query->orWhere($column, 'LIKE', '%' . $inputs['search'] . '%');
          $query->where('delete', false);
          // If its a children page then set filter by father id too
          if($father_id != null && $this->pageConf->collunIdFather != null){
            $query->where($this->pageConf->collunIdFather, $father_id);
          }
      }
      // Order by configuration
      $query->orderBy($configSelect->collumn, $configSelect->order);
      $rawData = $query->paginate(30);
      $rawData->paginate = $rawData->links();
      foreach($rawData as $key=>$line)
      {
        foreach($thisdata->listItemsTitle as $key2=>$collumn)
        {
          if(array_has($line, $collumn->collumn))
          {
            $collumnRename = $collumn->collumn . '_mask';
            $collumnName = $collumn->collumn;
            if($collumn->function == true){
              $nameFunction = 'get_'.$collumn->collumn;

              $controller = "App\Http\Controllers\Admin\\" . ucfirst($model_name) . "Controller";
              $controller = new $controller();
              $rawData[$key]->$collumnRename = $controller->$nameFunction($line, $collumn->collumn);
            }
            if($collumn->legenth > 0){
              $rawData[$key]->$collumnRename = str_limit($line->$collumnName, $collumn->legenth);
            }
          }
        }
      }

      $thisdata->listRegister = $rawData;

      return view('Admin.listdate')->with('thisdata', $thisdata);
    }
}
