<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Configuration;
use App\Models\Admin\Usuarios;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Image;
use Storage;

class UserProfileController extends Controller
{

    public $userProfile;

    public $_model;
    public $pageConf;

    public function __construct()
    {
        $this->_model = Usuarios::class; // Declaração do Model da página
        $this->pageConf = new \stdClass; //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData(); //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null"; //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageChildren = $this->getPageChildren(); //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro

    }
    public function profile()
    {

        $thisdata = new \stdClass;
        $thisdata->pageConf = $this->pageConf;

        $this->userProfile = auth()->user();
        
        $thisdata->userProfile = $this->userProfile;
        $thisdata->domainPattern = $this->getPattern();

        return view('Admin.Pages.userProfile', ['thisdata' => $thisdata]);

    }

    public function getPattern()
    {

        $config = Configuration::where('status', 1)->where('delete', 0)->first();

        $patternStrs = [
            'username' => $this->userProfile->name,
            'email' => explode('@', $this->userProfile->email)[0],
            'domainName' => $config->name
        ];

        foreach ($patternStrs as $key => $pattern) {
            $patternStrs[$key] = str_replace([' ', '.', '\''], "|", strtolower($pattern));
        }

        return implode('|', $patternStrs);
    }


    public function profilePostPicture(Request $request)
    {
        $this->userProfile = auth()->user();

        if (!empty($request->file('file'))) {

            $idMenu = $this->pageConf->pageData->id_nav_group_menu;
            $idRegister = $this->userProfile->id_login_user;

            $file = $request->file('file');

            $profilePicture = Image::make($file)->encode('webp');
            $imageLink = public_path("/uploads/" . md5($idMenu) . "/" . md5($idRegister) . "/");

            if (!file_exists($imageLink)) {
                mkdir($imageLink, 0775, true);
            }

            $imageLink .= md5($this->userProfile->name) . ".webp";

            $profilePicture->save($imageLink);

            preg_match('/\/uploads\/.*/', $imageLink, $matches);

            $updateData['profile_picture'] = $matches[0];

            Usuarios::where('id_login_user', $this->userProfile->id_login_user)->update($updateData);

        }

        return redirect()->route('usuario.perfil')->with(['message' => 'Foto de Perfil Atualizada']);
        ;
    }

    public function profilePost(Request $request)
    {
        $this->userProfile = auth()->user();

        $updateData = [];

        if ($this->userProfile->theme !== $request->theme) {
            $updateData['theme'] = $request['theme'];
        }

        if ($this->userProfile->name !== $request->name) {
            $updateData['name'] = $request['name'];
        }

        if (!empty($request['password']) && !empty($request['old_password'])) {
            if (!Hash::check($request['old_password'], $this->userProfile->password)) {
                return redirect()->back()->withErrors(['Senha Antiga não é corresponde ao valor inserido']);
            }

            $updateData['password'] = bcrypt($request['password']);
        }

        Usuarios::where('id_login_user', $this->userProfile->id_login_user)->update($updateData);

        return redirect()->route('usuario.perfil')->with(['message' => 'Cadastro Atualizado']);
    }
}