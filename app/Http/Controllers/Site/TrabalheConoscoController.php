<?php

namespace App\Http\Controllers\Site;
use App\Models\Admin\TrabalheConosco;
use App\Models\Admin\Beneficios;
use App\Models\Admin\Comercial;
use App\Models\Admin\Configurationmail;
use App\Models\Admin\Configuration;
use App\Models\Admin\Networks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailContact;

class TrabalheConoscoController extends Controller {
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
        $this->pageData->termos = $this->getTerms();
        $this->pageData->whatsapp = $this->getWhatsapp($this->pageData->networks);
        $this->pageData->address = $this->getAddress();
    }

	public function getBeneficios(){
        $beneficios = Beneficios::where('status', 1)->where('delete', 0)->get();
        $beneficios = $this->getUploadListArray(20, $beneficios, 'id_beneficio');
        return $beneficios;
    }
	
    public function index() {        
        
        $this->pageData->beneficios = $this->getBeneficios();
        $this->pageData->page = "Trabalhe Conosco";
        
        return view('Site.trabalheconosco')->with('thisdata', $this->pageData);
    }

    public function sendContact(Request $request) {        
        $response = new \stdClass;
		$allinputs = $request->all();

		if($this->check_send_form($allinputs)){
			$inputs = $request->except(['_token', 'secure']);

			// Get and verify if mail configs are OK
			$mail_config = Configurationmail::where('status', 1)->where('delete', 0)->first();
			$config = Configuration::where('status', 1)->where('delete', 0)->first();

			if(empty($mail_config)){
				// Set response values
				$response->status = 'error_reload';
				$response->message = 'Erro nas configs de email!';
				// Return response to view
				echo json_encode($response);
				return '';
			}

			$contact = new Contact;
			$contact->fill($inputs);
			if(!$contact->save()){
				$response->status = 'error_insert';
				$response->message = 'Erro ao salvar Contato!';
				echo json_encode($response);
				return '';
			}

			\Config::set('mail.driver', 'smtp');
			\Config::set('mail.host', $mail_config->smtp);
			\Config::set('mail.port', $mail_config->smtp_port);
			\Config::set('mail.username', $mail_config->mail_send);
			\Config::set('mail.password', $mail_config->password_mail_send);
			\Config::set('mail.encryption', $mail_config->ssl);

            $mail_lists = explode(',', $config->mail);
            foreach($mail_lists as $addreesmail){
                Mail::send(new mailContact($addreesmail, $inputs));
            }

            insertNotification('Nova solicitação de contato', "Notificação de contato",'sendcontacts');
			
            // Set response values
			$response->status = 'success';
			$response->message = 'Enviado com Sucesso!';
            
			// Return response to view
			echo json_encode($response);
			return '';
		} else {
			$response->status = 'error';
			$response->message = 'Erro, entre em contato!';
			echo json_encode($response);
			return '';
		}
        return view('Site.contato')->with('thisdata', $this->pageData);
    }

    private function check_send_form($inputs){
		if(empty($inputs['secure']) || $inputs['secure'] != 'vk2'){
			return false;
		} else {
			return true;
		}
	}
    
}
