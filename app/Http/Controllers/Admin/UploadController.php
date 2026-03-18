<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Navgroupmenu;
use App\Models\Admin\Upload;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use File;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;


class UploadController extends Controller
{
    private $uploads_path;

    public function __construct()
    {
        $this->_model = Upload::class; // Declaração do Model da página
        $this->pageConf = new \stdClass; //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData(); //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null"; //Pega link da pag. pai ('informar null caso nao tenha pag. pai')

        //Variavel para limpeza do cache
        $this->pageConf->pageCacheName = $this->pageConf->pageData->link;

        $this->uploads_path = public_path('/uploads');
    }

    // Abre página de carregamento de imagens
    public function uploadindex($page, $id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; // Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->pageConf->pageFather = $page; // Link da pag. do pai
        $thisdata->pageConf->idRegister = $id; // Link da pag. do pai
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page); // Pega o id de cadastro da página pai

        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 1); //resgatando lista de uploads

        

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.upload')->with('thisdata', $thisdata);

    }

    // Abre página de carregamento de arquivos
    public function uploadindexfile($page, $id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; // Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->pageConf->pageFather = $page; // Link da pag. do pai
        $thisdata->pageConf->idRegister = $id; // Link da pag. do pai
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page); // Pega o id de cadastro da página pai

        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 2); //resgatando lista de uploads


        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.uploadfile')->with('thisdata', $thisdata);

    }

    // Abre página de carregamento de videos
    public function uploadindexvideo($page, $id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; // Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->pageConf->pageFather = $page; // Link da pag. do pai
        $thisdata->pageConf->idRegister = $id; // Link da pag. do pai
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page); // Pega o id de cadastro da página pai

        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 3); //resgatando lista de uploads

        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.uploadvideo')->with('thisdata', $thisdata);

    }

    // Abre página de carregamento de videos
    public function uploadindexmobile($page, $id)
    {
        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; // Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento
        $thisdata->pageConf->pageFather = $page; // Link da pag. do pai
        $thisdata->pageConf->idRegister = $id; // Link da pag. do pai
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page); // Pega o id de cadastro da página pai

        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 4); //resgatando lista de uploads


        //carrega view padrão que será responsavel por carregar visualizaçao correta
        return view('Admin.uploadmobile')->with('thisdata', $thisdata);

    }

    //Função que seta caminho de cada arquivo
    private function getUrlFile($uploads)
    {

        $uploads_path = url('/uploads');

        foreach ($uploads as $key => $upload) {
            $path_menu = md5($upload->id_menu);
            $path_id = md5($upload->id_register);

            $uploads[$key]->imageFolder = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;
        }
        return $uploads;
    }


    // Função que pega a lista de ulploads do menu
    private function getUploadList($idMenu, $idRegister, $type, $thumb = NULL)
    {

        $uploads = DB::table('vpr_nav_group_menu_upload as upload')->where('upload.id_menu', $idMenu)->where('upload.id_type', $type)->where('upload.id_register', $idRegister)->where('upload.delete', false)->where('upload.status', true)->orderBy('order', 'ASC')->get();
        return $this->getUrlFile($uploads, $thumb);
    }

    /**
     * Pega todas as thumnails da pagina que esta upando arquivo
     */
    private function getThumbnails($pageFatherId)
    {
        return DB::table('vpr_nav_group_menu_thumb')->where('id_menu', $pageFatherId)->where('delete', false)->where('status', true)->get();
    }


    /**
     * Verifica a existencia da pasta de umplod,
     * Caso não exista cria com permissão correta
     */
    private function uploadsPathCheck($pageFatherId, $registerId, $thumbnails)
    {
        /**
         * Verifica se existe pasta raiz
         */
        if (!is_dir($this->uploads_path)) {
            mkdir($this->uploads_path, 0775, true);
        }

        /**
         * Verifica pasta raiz de conteudo
         */
        $name_path = md5($pageFatherId);
        $path_root_thiscontent = $this->uploads_path . '/' . $name_path;

        if (!is_dir($path_root_thiscontent)) {
            mkdir($path_root_thiscontent, 0775, true);
        }

        /**
         * Verifica pasta raiz de conteudo
         */
        $name_path_register = md5($registerId);
        $path_register_thiscontent = $path_root_thiscontent . '/' . $name_path_register;

        if (!is_dir($path_register_thiscontent)) {
            mkdir($path_register_thiscontent, 0775, true);
        }

        /**
         * Verifica pastas de thumbnail
         */
        foreach ($thumbnails as $thumb) {
            $path_thumb = $path_register_thiscontent . '/' . $thumb->storange_name;

            if (!is_dir($path_thumb)) {
                mkdir($path_thumb, 0775, true);
            }
        }
    }

    private function setNameSalve($nameOriginal)
    {
        $nameOriginal = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($nameOriginal)));
        $nameOriginal = preg_replace("/[^ \w\-.]+/", "", $nameOriginal);
        $nameNoCharracters = str_replace(" ", "-", $nameOriginal);
        return md5(date("Ymdhsi") . $nameNoCharracters);
    }

    /**
     * Saving Upload Thumbnail
     *
     */
    private function saveImgeThumb($file, $thumbnails, $filevar, $path_thiscontent)
    {
        foreach ($thumbnails as $thumb) {
            $configThumb = new \stdClass;
            $configThumb->folder = $path_thiscontent . '/' . $thumb->storange_name;

            // $thumUpload = Image::make($file)->encode($filevar->extencionOriginal, 60);
            $thumUpload = Image::make($file)->encode('webp');
            $thumUpload->resize($thumb->width, $thumb->height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $thumUpload->save($configThumb->folder . '/' . $filevar->nameForSave);
        }
        return true;
    }

    private function getRealNameUpload($path)
    {
        $pathexplode = explode('/', $path);
        return last($pathexplode);
    }


    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        /**
         * Request fotos para uma variavel para iniciar as configurações
         */
        $file = $request->file('file');

        /**
         * Pega lista de Thumbnails
         */
        $thumbnails = $this->getThumbnails($pageFatherId);

        /**
         * Checar e configurar as pastas raiz, conteudo e Thumbnail
         */
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        /**
         * Inicia o upload
         */

        /**
         * Se for array veio algo errado encerra execução
         */
        if (!is_array($file)) {
            /**
             * Definição de variaveis poadrao para upload de imagens
             */
            $filevar = new \stdClass;
            $filevar->nameOriginal = $file->getClientOriginalName();
            $filevar->extencionOriginal = $file->getClientOriginalExtension();
            $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.webp';
            if ($filevar->extencionOriginal == 'gif') {
                $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.' . $filevar->extencionOriginal;
            }
            $filevar->descriptionOriginal = $file->getClientOriginalName();
            $filevar->author = '';
            $filevar->direct = '';
            $filevar->mimeType = $file->getMimeType();

            /**
             * Teste de formato Liberado
             */
            // if
            // $validator = Validator::make($file, [
            //     'filepond' => 'mimetypes:audio/mp3'
            // ]);


            /**
             * Guarda nome do caminho raiz para salvar arquivos
             */
            $name_path = md5($pageFatherId);
            $name_path_register = md5($registerId);
            $path_thiscontent = $this->uploads_path . '/' . $name_path . '/' . $name_path_register;

            /**
             * Guarda arquivo original da pasta adequada
             */
            $guardFileOriginal = Image::make($file)->encode('webp');
            if ($filevar->extencionOriginal == 'gif') {
                $guardFileOriginal = Image::make($file)->encode('gif');
            }
            if ($guardFileOriginal->save($path_thiscontent . '/' . $filevar->nameForSave)) {

                if ($this->saveImgeThumb($file, $thumbnails, $filevar, $path_thiscontent)) {

                    $upload = new Upload();
                    $upload->id_menu = $pageFatherId;
                    $upload->id_register = $registerId;
                    $upload->id_type = 1;
                    $upload->extension = $filevar->extencionOriginal;
                    $upload->name = $filevar->nameForSave;
                    $upload->description = $filevar->descriptionOriginal;
                    $upload->author = $filevar->author;
                    $upload->image_rights = $filevar->direct;
                    $upload->order = 1;
                    $upload->save();

                    return Response::json([
                        'message' => 'Image saved Successfully'
                    ], 200);
                }

            }
        }
        return Response::json([
            'message' => 'IncorrectSendFile',
            'code' => '100'
        ], 200);

        // Image::make($file)->resize(250, null, function ($constraints) { $constraints->aspectRatio(); })->encode($file->getClientOriginalExtension(), 60)->save($this->uploads_path . '/' . $resize_name);
        // Image::make($file)->encode($file->getClientOriginalExtension(), 60)->save($this->uploads_path . '/' . $save_name);
        // Image::make($file)->resize(550, null, function ($constraints) { $constraints->aspectRatio(); })->encode($file->getClientOriginalExtension(), 60)->save($this->uploads_path . '/' . $resize_name2);




    }

    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function savemobile(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        /**
         * Request fotos para uma variavel para iniciar as configurações
         */
        $file = $request->file('file');

        /**
         * Pega lista de Thumbnails
         */
        $thumbnails = $this->getThumbnails($pageFatherId);

        /**
         * Checar e configurar as pastas raiz, conteudo e Thumbnail
         */
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        /**
         * Inicia o upload
         */

        /**
         * Se for array veio algo errado encerra execução
         */
        if (!is_array($file)) {
            /**
             * Definição de variaveis poadrao para upload de imagens
             */
            $filevar = new \stdClass;
            $filevar->nameOriginal = $file->getClientOriginalName();
            $filevar->extencionOriginal = $file->getClientOriginalExtension();
            $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.webp';
            if ($filevar->extencionOriginal == 'gif') {
                $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.' . $filevar->extencionOriginal;
            }
            $filevar->descriptionOriginal = $file->getClientOriginalName();
            $filevar->author = '';
            $filevar->direct = '';
            $filevar->mimeType = $file->getMimeType();

            /**
             * Teste de formato Liberado
             */
            // if
            // $validator = Validator::make($file, [
            //     'filepond' => 'mimetypes:audio/mp3'
            // ]);


            /**
             * Guarda nome do caminho raiz para salvar arquivos
             */
            $name_path = md5($pageFatherId);
            $name_path_register = md5($registerId);
            $path_thiscontent = $this->uploads_path . '/' . $name_path . '/' . $name_path_register;

            /**
             * Guarda arquivo original da pasta adequada
             */
            $guardFileOriginal = Image::make($file)->encode('webp');
            if ($filevar->extencionOriginal == 'gif') {
                $guardFileOriginal = Image::make($file)->encode('gif');
            }
            if ($guardFileOriginal->save($path_thiscontent . '/' . $filevar->nameForSave)) {

                if ($this->saveImgeThumb($file, $thumbnails, $filevar, $path_thiscontent)) {

                    $upload = new Upload();
                    $upload->id_menu = $pageFatherId;
                    $upload->id_register = $registerId;
                    $upload->id_type = 4;
                    $upload->extension = $filevar->extencionOriginal;
                    $upload->name = $filevar->nameForSave;
                    $upload->description = $filevar->descriptionOriginal;
                    $upload->author = $filevar->author;
                    $upload->image_rights = $filevar->direct;
                    $upload->order = 1;
                    $upload->save();

                    return Response::json([
                        'message' => 'Image saved Successfully'
                    ], 200);
                }

            }
        }
        return Response::json([
            'message' => 'IncorrectSendFile',
            'code' => '100'
        ], 200);
    }

    /**
     * Saving Files uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function savefile(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        /**
         * Request fotos para uma variavel para iniciar as configurações
         */
        $file = $request->file('file');
        /**
         * Request thumbnails
         */
        $thumbnails = $this->getThumbnails($pageFatherId);

        /**
         * Checar e configurar as pastas raiz, conteudo e Thumbnail
         */
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        if (!is_array($file)) {

            $fileReceiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

            if ($fileReceiver->isUploaded() === false) {
                return Response::json([
                    'message' => 'IncorrectSendFile',
                    'code' => '100'
                ], 200);
            }

            $save = $fileReceiver->receive();

            if ($save->isFinished()) {



                $unChunkedFile = $save->getFile();
                /**
                 * Definição de variaveis poadrao para upload de imagens
                 */
                $filevar = new \stdClass;
                $filevar->nameOriginal = $unChunkedFile->getClientOriginalName();
                $filevar->extencionOriginal = $unChunkedFile->getClientOriginalExtension();
                $filevar->descriptionOriginal = $unChunkedFile->getClientOriginalName();
                $filevar->author = '';
                $filevar->direct = '';
                $filevar->mimeType = $unChunkedFile->getMimeType();

                /**
                 * Guarda nome do caminho raiz para salvar arquivos
                 */
                $name_path = md5($pageFatherId);
                $name_path_register = md5($registerId);
                $fileName = md5($filevar->nameOriginal);
                $path_thiscontent = $name_path . '/' . $name_path_register . '/' . $fileName . "." . $filevar->extencionOriginal;
                $path_thiscontent = Storage::disk('uploads')->path('') . $path_thiscontent;

                File::move($unChunkedFile->getRealPath(), $path_thiscontent);

                $upload = new Upload();
                $upload->id_menu = $pageFatherId;
                $upload->id_register = $registerId;
                $upload->id_type = 2;
                $upload->extension = $filevar->extencionOriginal;
                $upload->name = $this->getRealNameUpload($path_thiscontent);
                $upload->description = $filevar->descriptionOriginal;
                $upload->author = $filevar->author;
                $upload->image_rights = $filevar->direct;
                $upload->order = 1;
                $upload->save();


                return Response::json([
                    'message' => 'File saved Successfully'
                ], 200);
            }

            $handler = $save->handler();

            return Response::json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ], 200);
        }
    }

    public function savevideo(Request $request, $pageFatherId, $registerId)
    {

        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        /**
         * Request fotos para uma variavel para iniciar as configurações
         */
        $file = $request->file('file');
        /**
         * Request thumbnails
         */
        $thumbnails = $this->getThumbnails($pageFatherId);

        /**
         * Checar e configurar as pastas raiz, conteudo e Thumbnail
         */
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        if (!is_array($file)) {

            $fileReceiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

            if ($fileReceiver->isUploaded() === false) {
                return Response::json([
                    'message' => 'IncorrectSendFile',
                    'code' => '100'
                ], 200);
            }

            $save = $fileReceiver->receive();

            if ($save->isFinished()) {



                $unChunkedFile = $save->getFile();
                /**
                 * Definição de variaveis poadrao para upload de imagens
                 */
                $filevar = new \stdClass;
                $filevar->nameOriginal = $unChunkedFile->getClientOriginalName();
                $filevar->extencionOriginal = $unChunkedFile->getClientOriginalExtension();
                $filevar->descriptionOriginal = $unChunkedFile->getClientOriginalName();
                $filevar->author = '';
                $filevar->direct = '';
                $filevar->mimeType = $unChunkedFile->getMimeType();

                /**
                 * Guarda nome do caminho raiz para salvar arquivos
                 */
                $name_path = md5($pageFatherId);
                $name_path_register = md5($registerId);
                $fileName = md5($filevar->nameOriginal);
                $path_thiscontent = $name_path . '/' . $name_path_register . '/' . $fileName . "." . $filevar->extencionOriginal;
                $path_thiscontent = Storage::disk('uploads')->path('') . $path_thiscontent;

                File::move($unChunkedFile->getRealPath(), $path_thiscontent);

                $upload = new Upload();
                $upload->id_menu = $pageFatherId;
                $upload->id_register = $registerId;
                $upload->id_type = 3;
                $upload->extension = $filevar->extencionOriginal;
                $upload->name = $this->getRealNameUpload($path_thiscontent);
                $upload->description = $filevar->descriptionOriginal;
                $upload->author = $filevar->author;
                $upload->image_rights = $filevar->direct;
                $upload->order = 1;
                $upload->save();


                return Response::json([
                    'message' => 'File saved Successfully'
                ], 200);
            }

            $handler = $save->handler();

            return Response::json([
                "done" => $handler->getPercentageDone(),
                'status' => true
            ], 200);
        }
    }


    // /**
    //  * Remove the images from the storage.
    //  *
    //  * @param Request $request
    //  */
    public function deleteUpload($id)
    {   
        $fileId = $id;
        $upload_register = $this->_model::where('id_upload', $fileId)->get();
        $response = new \stdClass;

        $path_menu = md5($upload_register[0]->id_menu);
        $path_id = md5($upload_register[0]->id_register);
        $file_name = $upload_register[0]->name;
        $id_menu = $upload_register[0]->id_menu;

        $file_path = $this->uploads_path . '/' . $path_menu . '/' . $path_id . '/';

        $fileUnlink = $file_path . $file_name;

        if ($this->_model::where('id_upload', $fileId)->update(['delete' => true])) {

            if (file_exists($fileUnlink)) {
                unlink($fileUnlink);
            }

            $thumbs = DB::table('vpr_nav_group_menu_thumb')->where('id_menu', $id_menu)->where('delete', false)->where('status', true)->get();

            foreach ($thumbs as $thumb) {

                $fileThumbUnlink = $file_path . $thumb->storange_name . '/' . $file_name;

                if (file_exists($fileThumbUnlink)) {
                    unlink($fileThumbUnlink);
                }
            }

            $name = Navgroupmenu::select('link')->find($upload_register[0]->id_menu);
            Cache::forget($name->link);

            $response->status = 'true';
            $response->message = 'Deletado com sucesso';
        } else {
            $response->status = 'error';
            $response->message = 'Erro! Registros não puderam ser deletados!';
        }
        echo json_encode($response);

    }

    public function sortable(Request $request)
    {
        foreach ($request->ordem as $ordenar) {
            $updateorder = Upload::find($ordenar['id_upload']);
            $updateorder->order = $ordenar['order'];
            $updateorder->save();
        }
        return 'true';
    }

    // public function clearCacheUpload()
    // {
    //     Cache::forget($this->pageConf->pageCacheName);
    // }

    public function galleryUpload(Request $request, $pageFatherId)
    {
        $registerId = '9999';

        $name = Navgroupmenu::select('link')->find($request->segment(4));

        Cache::forget($name->link);

        /**
         * Request fotos para uma variavel para iniciar as configurações
         */
        $file = $request->file('file');
        /**
         * Pega lista de Thumbnails
         */
        $thumbnails = $this->getThumbnails($pageFatherId);

        /**
         * Checar e configurar as pastas raiz, conteudo e Thumbnail
         */
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        /**
         * Se for array veio algo errado encerra execução
         */
        if (!is_array($file)) {

            /**
             * Definição de variaveis poadrao para upload de imagens
             */
            $filevar = new \stdClass;
            $filevar->nameOriginal = $file->getClientOriginalName();
            $filevar->extencionOriginal = $file->getClientOriginalExtension();
            $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.webp';
            if ($filevar->extencionOriginal == 'gif') {
                $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.' . $filevar->extencionOriginal;
            }
            $filevar->descriptionOriginal = $file->getClientOriginalName();
            $filevar->author = '';
            $filevar->direct = '';
            $filevar->mimeType = $file->getMimeType();


            /**
             * Guarda nome do caminho raiz para salvar arquivos
             */
            $name_path = md5($pageFatherId);
            $name_path_register = md5($registerId);
            $path_thiscontent = $this->uploads_path . '/' . $name_path . '/' . $name_path_register;

            /**
             * Guarda arquivo original da pasta adequada
             */
            $guardFileOriginal = Image::make($file);
            if ($filevar->extencionOriginal == 'gif') {
                $guardFileOriginal = Image::make($file)->encode('gif');
            }
            if ($guardFileOriginal->save($path_thiscontent . '/' . $filevar->nameForSave)) {


                if ($this->saveImgeThumb($file, $thumbnails, $filevar, $path_thiscontent)) {

                    $upload = new Upload();
                    $upload->id_menu = $pageFatherId;
                    $upload->id_register = $registerId;
                    $upload->id_type = 1;
                    $upload->extension = $filevar->extencionOriginal;
                    $upload->name = $filevar->nameForSave;
                    $upload->description = $filevar->descriptionOriginal;
                    $upload->author = $filevar->author;
                    $upload->image_rights = $filevar->direct;
                    $upload->order = 1;
                    $upload->save();
                    $upload->refresh();
                    // dump($upload);

                    $uploads_path = url('/uploads');
                    $path_menu = md5($upload->id_menu);
                    $path_id = md5($upload->id_register);

                    $url = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;

                    // dd($url);

                    return Response::json([
                        'message' => 'Image saved Successfully',
                        'data' => [
                            'idUpload' => $upload->id_upload,
                            'imgUrl' => $url
                        ]
                    ], 200);
                }
            }
        } else {

            return Response::json([
                'message' => 'IncorrectSendFile',
                'code' => '100'
            ], 500);
        }
    }

    public function galleryPage(Request $request, $menu, $page)
    {

        $upload = DB::table('vpr_nav_group_menu_upload as upload')
            ->select(['id_upload', 'id_menu', 'id_register', 'name'])
            ->where('upload.id_menu', $menu)
            ->where('upload.id_register', '9999')->where('upload.delete', false)
            ->where('upload.status', true)->orderby('id_upload', 'DESC')->skip(($page - 1) * 3)->take(3)->get();
        $uploads_path = url('/uploads');

        if ($upload->isEmpty()) {
            return Response::json([
                'success' => false,
                'message' => 'empty query',
                'data' => null,
            ], '200');
        }

        foreach ($upload as $key => $upload) {
            $path_menu = md5($upload->id_menu);
            $path_id = md5($upload->id_register);

            $url = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;

            $returnData[] = [
                'idUpload' => $upload->id_upload,
                'imgUrl' => $url
            ];
        }

        return Response::json([
            'success' => true,
            'data' => $returnData
        ], 200);
    }
}
