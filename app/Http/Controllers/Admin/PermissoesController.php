<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Permissoes;
use DB;

class PermissoesController extends Controller
{
    public function __construct()
    {
        $this->_model = Permissoes::class;                                                // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null";                                             //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }


    public function updatepermissoes(Permissoes $permissoes)
    {
      
      $idUser = $_POST['user'];           //Id do usuario que estamos alterando permissão;
      $idNavGroupMenu = $_POST['page'];   // Id da página que estamos permitindo ou negando
      $idAction = $_POST['action'];       //Id de açao permitida ao usuario Ex. (0 = tudo, 1= visualizar, 2=inserir, 3= Alterar, 4= Deletar, 5= Upload, 6= Alterar Status)
      $active = $_POST['active'];         // 0 = desativado deve ativar, 1 = ativado deve desativar
      

      //Testa se deve ser ativado ou desativado
      if($active == 0){
        
        // Testa qual permissão está sendo atibuida e efetua procedimento
        if($idAction == 0){
          
         if(Permissoes::where('id_user', $idUser)->where('id_menu', $idNavGroupMenu)->update(['view'=> 1, 'edit'=> 1, 'add'=> 1, 'delete'=> 1, 'upload'=> 1, 'status'=> 1,])){
           echo 'true';
           exit;
          }
          echo 'false';
          
        } else if($idAction == 1){
          
          if(Permissoes::where('id_user', $idUser)
                                  ->where('id_menu', $idNavGroupMenu)
                                  ->update(['view' => 1])){
           echo 'true';
           exit;
          }
          echo 'false';
        
        } else {
            
          switch ($idAction) {
            case 2:
                $name = "edit";
                break;
            case 3:
                $name = "add";
                break;
            case 4:
                $name = "delete";
                break;
            case 5:
                $name = "upload";
                break;
            case 6:
                $name = "status";
                break;
          }
           if(Permissoes::where('id_user', $idUser)
                                ->where('id_menu', $idNavGroupMenu)
                                ->update([
                                  'view' => 1,
                                  $name => 1,
                                ])){
           echo 'true';
           exit;
          }
          echo 'false';
          
        }
        
      } else {
        
        if($idAction == 0){
          
         if(Permissoes::where('id_user', $idUser)->where('id_menu', $idNavGroupMenu)->update(['view'=> 0, 'edit'=> 0, 'add'=> 0, 'delete'=> 0, 'upload'=> 0, 'status'=> 0,])){
           echo 'true';
           exit;
          }
          echo 'false';
          
        } else if($idAction == 1){
          
          if(Permissoes::where('id_user', $idUser)->where('id_menu', $idNavGroupMenu)->update(['view'=> 0, 'edit'=> 0, 'add'=> 0, 'delete'=> 0, 'upload'=> 0, 'status'=> 0,])){
           echo 'true';
           exit;
          }
          echo 'false';
        
        } else {
            
          switch ($idAction) {
            case 2:
                $name = "add";
                break;
            case 3:
                $name = "edit";
                break;
            case 4:
                $name = "delete";
                break;
            case 5:
                $name = "upload";
                break;
            case 6:
                $name = "status";
                break;
          }
           if(Permissoes::where('id_user', $idUser)
                                ->where('id_menu', $idNavGroupMenu)
                                ->update([$name => 0,])){
           echo 'true';
           exit;
          }
          echo 'false';
          
        }
        
        
        
      }
      
      
    }


    public function getuserclone(){
      $thisdata = new \stdClass;
      
      $idUser = $_POST['user'];                    //Id do usuario que estamos setando permissão;
      $idPermission = $_POST['permission'];           //Id do tipo de permissao do usuario;
      
      
      $thisdata->allUser = DB::table('vpr_login_users as user')
                              ->join('vpr_login_permissions as permission', 'permission.id_login_permission', '=', 'user.id_permission')
                              ->select('user.name', 'user.id_login_user', 'user.id_login_user', 'permission.name as type_user')
                              ->where('user.id_login_user', '!=', $idUser)
                              ->where('user.id_class', 1)
                              ->where('user.id_permission', $idPermission)
                              ->get();

      $thisdata->response = array('success' => 'true', 'usuarios' => $thisdata->allUser);
      
      echo json_encode($thisdata->response);

    }

    public function cloneUser(Permissoes $permissoes){
      $idUserClone = $_POST['idUserClone'];                     //Id do usuario que estamos clonando;
      $idUserUpdate = $_POST['idUserUpdate'];                    //Id do usuario que receberá permissões;
      $response = new \stdClass;
      $response->status = 'true';
      $response->message = 'Clone criado com sucesso!';
      $response->updates = [];

      $allPermissionClone = Permissoes::where('id_user', $idUserClone)->get();
      $allPermissionUpdate = DB::table('vpr_permission as permissao')
      ->join('vpr_nav_group_menu as menu', 'menu.id_nav_group_menu', '=', 'permissao.id_menu')
      ->select('permissao.*', 'menu.name as menuName')
      ->where('permissao.id_user', $idUserUpdate)
      ->get();

      foreach($allPermissionUpdate as $key=>$update)
      {
        $keyClone = $allPermissionClone->where('id_menu', $update->id_menu)->keys();
        if(!$keyClone->isEmpty()){

          $keyCloneNumber = $keyClone[0];
          if(Permissoes::where('id_permission', $update->id_permission)->update(['view' => $allPermissionClone[$keyCloneNumber]->view, 'edit' => $allPermissionClone[$keyCloneNumber]->edit, 'add' => $allPermissionClone[$keyCloneNumber]->add, 'delete' => $allPermissionClone[$keyCloneNumber]->delete, 'upload' => $allPermissionClone[$keyCloneNumber]->upload, 'status' => $allPermissionClone[$keyCloneNumber]->status]))
          {
            $response->updates[$key] = ['menu'=>$update->id_menu, 'status'=>'true', 'name'=>$update->menuName];
          } else {
            $response->status = 'false';
            $response->updates[$key] = ['menu'=>$update->id_menu, 'status'=>'false', 'name'=>$update->menuName];
            $response->message = 'Uma ou maos permissões não foram copiadas com sucesso!';
          }
        } else {
          $response->status = 'error';
          $response->updates[$key] = ['menu'=>$update->id_menu, 'status'=>'error', 'name'=>$update->menuName];
          $response->message = 'Erro inesperado!';
        }
      }

      echo json_encode($response); 

    }


}
