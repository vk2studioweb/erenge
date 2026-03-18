<?php

namespace App\Http\Controllers\Site;

use App\Models\Admin\Configuration;
use App\Models\Admin\Networks;
use App\Models\Admin\Externallinks;
use App\Models\Admin\Business;
use App\Models\Admin\Address;
use App\Models\Admin\Polices;
use App\Models\Admin\Texts;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Requests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Datetime;
use Auth\suporte;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->pageData = new \stdClass;
    }

    /*____________________________________________________*/

    function translatemonth($month){
        $months = array('01'=>'JANEIRO', '02'=>'FEVEREIRO', '03'=>'MARÇO', '04'=>'ABRIL', '05'=>'MAIO', '06'=>'JUNHO', '07'=>'JULHO', '08'=>'AGOSTO', '09'=>'SETEMBRO', '10'=>'OUTUBRO', '11'=>'NOVEMBRO', '12'=>'DEZEMBRO');
        return $months[$month];
    }

    function tranlateday($dia){
        $dias = array("Sunday"=>"Domingo", "Monday"=>"Segunda-feira", "Tuesday"=>"Terça-feira", "Wednesday"=>"Quarta-feira", "Thursday"=>"Quinta-feira", "Friday"=>"Sexta-feira", "Saturday"=>"Sábado");
        return $dias[$dia];
    }

    /**
    * Função pegar imagens e caminhos de imagens
    */

    //Função que seta caminho de cada arquivo
    public function getUrlFile($upload, $thumbs=null){

        $registro = new \stdClass;
        $uploads_path = url('/uploads'); //Base Url Site para carregamento das imagens
       
        $path_menu = md5($upload->id_menu);  //Nome real da pasta do menu selecionado
        $path_id = md5($upload->id_register); //Nome real da pasta do registro selecionado

        $registro->default = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;        
        $registro->description = $upload->description;        
        $registro->name = $upload->name;        

        foreach($thumbs as $thumb){
            $storageName = $thumb->storange_name; //Nome do diretorio daThumb
            $registro->$storageName = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $storageName . '/' . $upload->name;
        }        
        
        return $registro;
    }    
    // Função que pega a lista de ulploads do menu para lista de dados
    public function getUploadListArray($idMenu, $registers, $nameCollun){

        //Pega todas as thumbs deste registro
        $thumbs = DB::table('vpr_nav_group_menu_thumb')->where('id_menu', $idMenu)->where('delete', false)->where('status', true)->get();
        $uploads =  DB::table('vpr_nav_group_menu_upload as upload')->where('upload.id_menu', $idMenu)->orderBy('order', 'ASC');

        $uploads->where(function($query) use ($registers, $nameCollun) {
            foreach ($registers as $registre) {
                $query->orWhere('upload.id_register', $registre->$nameCollun);
            }
        });
        
        $uploads->where('delete', false);
        $uploads->where('status', true);
        // $files = $uploads->toSql(); 
        $files = $uploads->get();
        
        //Impressão da querry
        if(!empty($files)){
            foreach ($registers as $key => $register) {

                $registers[$key]->images = collect();
                $registers[$key]->videos = collect();
                $registers[$key]->files  = collect();

                foreach ($files as $upload) { 
                    if ($register->$nameCollun == $upload->id_register) {
                        if($upload->id_type == 1){
                            $registers[$key]->images->push($this->getUrlFile($upload, $thumbs)); 
                        } else if($upload->id_type == 2){
                            $registers[$key]->files->push($this->getUrlFile($upload, $thumbs));
                        } else if($upload->id_type == 3){                                
                            $registers[$key]->videos->push($this->getUrlFile($upload, $thumbs));
                        }
                    }
                }
            }
        }
        return $registers;  
    }

    /**
    * Saving images uploaded through XHR Request.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function uploadsave(Requests $request)
    {
        $this->uploads_path = public_path('/uploads/site');

        /**
        * Recolhe valores obrigatório para o upload
        * -> Arquivo
        * -> ID do cadastro vinculado a imagem
        * -> Pasta de armazenamento
        */
        $file = $request->file('file');
        $id = $request->id;
        $folder = $request->folder;
        /**
        * Definição de variaveis padrão para upload de imagens
        */
        $filevar = new \stdClass;
        // Valida se ocorreram erros no upload
        $filevar->error = $file->getError();

        if($filevar->error == true){
            // Retorna erro no upload
            $response = new \stdClass;
            $response->status = $filevar->error;
            // Retorna resposta
            echo json_encode($response);
            return '';
        }

        $filevar->nameOriginal = $file->getClientOriginalName();
        $filevar->extencionOriginal = $file->getClientOriginalExtension();
        $filevar->time_hash = md5(date('YmdHis'));
        $filevar->nameForSave = md5($filevar->time_hash . $filevar->nameOriginal) . '.' . $filevar->extencionOriginal;
        $filevar->mimeType = $file->getMimeType();
        $filevar->id = $id;

        /**
        * Recolhe lista de Thumbnails definidas no controller
        */
        $thumbnails = collect();
        if(method_exists($this, 'getThumbnails')){
            $thumbnails = $this->getThumbnails();
        }

        /**
        * Verifica pastas de armazenameno
        */
        if(!is_dir($this->uploads_path)){
            mkdir($this->uploads_path, 0777);
        }

        /**
        * Criptografa pastas internas para salvar upload
        */
        $nameFolder = md5($folder);
        $uploadPhath = $this->uploads_path . '/' . $nameFolder;
        if(!is_dir($uploadPhath))
        {
            mkdir($uploadPhath, 0777);
        }

        $nameFolderRegister = md5($id);
        $uploadPhathRegister = $uploadPhath . '/' . $nameFolderRegister;
        if(!is_dir($uploadPhathRegister))
        {
            mkdir($uploadPhathRegister, 0777);
        }

        /**
        * Inicia upload thumb
        */
        foreach($thumbnails as $key => $thumb)
        {
            $pathThumb = $uploadPhathRegister . '/' . $thumb['folder'];
            if(!is_dir($pathThumb))
            {
                mkdir($pathThumb, 0777);
            }

            $thumUpload = Image::make($file)->encode($filevar->extencionOriginal, 60);
            $thumUpload->resize($thumb['largura'] , $thumb['altura'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $thumUpload->save($pathThumb . '/' . $filevar->nameForSave);
        }

        /**
        * Upload original
        */
        $guardFileOriginal = Image::make($file)->encode($filevar->extencionOriginal, 60);
        if($guardFileOriginal->save($uploadPhathRegister . '/' . $filevar->nameForSave))
        {
            $this->salveDadosFile($filevar, $uploadPhathRegister);
        }
    }

    // Recebe e-mail e ofusca caracteres
    function maskHideEmail($email) {
        $explode = explode('@',$email);
        $rest = substr($explode[0], 0, 3);
        return $rest."***@".$explode[1];
    }


    /**
    * Saving files uploaded through XHR Request.
    * The file storage path is defined has folllows:
    * Storage Disk path + folder name in md5 + ID of the register in md5 + file original name in Laravel custom cryptography.
    * Once successfully saved, if the optional parameter $model has been set
    * it saves the upload register in the model table and returns Bolean true on success, if not set it returns the file name.
    * On error return Bolean false.
    * @var String $disk_name
    * @var \Illuminate\Http\UploadedFile $file
    * @var Integer $id
    * @var String $folder_name
    * @var Illuminate\Database\Eloquent\Model $model
    * @return Boolean
    * @return String
    */
    public function storeFile($disk_name, $folder_name, $id, $file, $model = null){
        // Generate the storage path
        $storePath = md5($folder_name) . '/' . md5($id);

        // Atempt to save file
        try {
            $savedPath = Storage::disk($disk_name)->putFile($storePath, $file, 'public');

            // Gets the file generated name
            preg_match("/[^\/]+$/", $savedPath , $matches);
            $filename = $matches[0];

            // If $model is set them attempt to save
            if($model != null){
                $file_data = new $model;
                $file_data->id_bound = $id;
                $file_data->name = $filename;
                $file_data->original_name = $file->getClientOriginalName();
                $file_data->extension = $file->getClientOriginalExtension();
                $file_data->save();

                return true;
            }
            // Else return file generated name
            else{
                return $filename;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
    * Retrieve file URL path from storage disks.
    * If file is found return the path in String, else return Boolean false
    * @var String $disk_name
    * @var String $folder_name
    * @var Integer $id
    * @var String $file_name
    * @return Boolean
    * @return String
    */
    public function getFileURL($disk_name, $folder_name, $id, $file_name){
        // Generate the storage path
        $storePath = md5($folder_name) . '/' . md5($id);

        // Check if file exists
        if(Storage::disk($disk_name)->exists($storePath . '/' . $file_name))
        return Storage::disk($disk_name)->url($storePath . '/' . $file_name);
        else
        return false;
    }

    // File mimetype validations
    public function fileMimeValidate($file, Array $valid_mimetypes){
        $filevar = new \stdClass;
        $filevar->mimeType = $file->getMimeType();
        foreach($valid_mimetypes as $mimetype){
            if($filevar->mimeType == $mimetype)
            return true;
        }
        return false;
    }

     /**
     * Função de carregamento de valores de selects
     * Verifica se metodo chamado existe e o executa com parametro recebido
    */
    public function getSelectData($method, $id){
        if(method_exists($this, $method)){
          return call_user_func(array($this, $method), $id);
        }
    }

    /**
    * Função para pegar dados de exibição de select para cidades
    *
    */
    public function getCity($id){
        $result =  DB::table('vpr_countries_states_cities as cities')
                ->select('cities.id_city as value', 'cities.name as text')
                ->where('cities.id_state', $id)
                ->get();
        return $result;
    }

    // Function to validate CPF
    function validateCPF($cpf) {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    // Function to validate CNPJ
    function validateCNPJ($cnpj){
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
        return false;
        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
        return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
        return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    /** Carregamento de conteúdo dinámico da página */

	public function getTexts(){
        $texts = Texts::where('status', 1)->where('delete', 0)->get();
        $texts = $this->getUploadListArray(12, $texts, 'id_text');
        if(!empty($texts)){
            $texts = $texts->groupBy('info_location');
            return $texts;
        }
        return "";
    }

    public function getConfig(){
        $config = Configuration::where('status', 1)->where('delete', 0)->first();
        return $config;
    }

    public function getNetworks()
    {
        $result = Networks::where('print_list', 1)->where('status', 1)->where('delete', 0)->get();
        return $result;
    }

    public function getBusiness() {
        $result = Business::where('status', 1)->where('delete', 0)->get();
        return $result;
    }

    public function getLink($slug = null) {
        $result = Externallinks::where('status', 1)->where('delete', 0)->where('slug', $slug)->first();
        return $result;
    }
    
    public function getAddress() {
       $result = Address::where('status', '=', 1) ->where('delete', '=', 0)->get();
       return $result;
    }

    public function getTerms() {
        $result = Polices::where('status', 1) ->where('delete', 0)->get();
        return $result;
     }

    public function setFormateDate($registers)
    {
        $mesesName = array('01'=>'Jan.','02'=>'Fev.','03'=>'Mar.','04'=>'Abr.','05'=>'Mai.','06'=>'Jun.','07'=>'Jul.','08'=>'Ago.','09'=>'Set.','10'=>'Out.','11'=>'Nov.','12'=>'Dez.');
        
        foreach($registers as $key => $register)
        {
            $dia = date('d', strtotime($register->created_at));
            $mes = date('m', strtotime($register->created_at));
            $ano = date('Y', strtotime($register->created_at));
            $mes_ptbr = $mesesName[$mes];
            $registers[$key]->printdate = $dia . ' de ' . $mes_ptbr . ' ' . $ano;
        }
        return $registers;
    }
    public function getWhatsapp($redes_sociais)
    {
        // Retorna o objeto ou null se não encontrar
        return $redes_sociais->where('icon', 'whatsapp')->first();
    }

}
