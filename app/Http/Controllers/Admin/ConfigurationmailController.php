<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Configurationmail;
use Illuminate\Http\Request;

class ConfigurationmailController extends Controller
{
    public function __construct()
    {
        $this->_model = Configurationmail::class;                                                  // Declaração do Model da página
        $this->pageConf = new \stdClass;                                                  //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData();                                 //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null";                                             //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageChildren = $this->getPageChildren();                         //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function getRadioCorrect($register)
    {
        $register[0]->opcao1 = ($register[0]->ssl == 1) ? true : false;
        $register[0]->opcao2 = ($register[0]->ssl == 0) ? true : false;
        return $register;
    }

    public function checkDataBeforeLoad($register)
    {
        //função para teste
        $register = $this->getRadioCorrect($register);
        return $register;
    }

    public function checkBeforeUpdate($register)
    {
        if($register['password_mail_send'] == '' || empty($register['password_mail_send']))
        {
            unset($register['password_mail_send']);
        }
        return $register;
    }

}
