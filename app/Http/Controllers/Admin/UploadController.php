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
        $this->_model = Upload::class;
        $this->pageConf = new \stdClass;
        $this->pageConf->pageData = $this->getPageData();
        $this->pageConf->pageFather = "null";
        $this->pageConf->pageCacheName = $this->pageConf->pageData->link;
        $this->uploads_path = public_path('/uploads');
    }

    // Abre página de carregamento de imagens
    public function uploadindex($page, $id)
    {
        $thisdata = new \stdClass;
        $thisdata->pageConf = $this->pageConf;
        $thisdata->pageConf->pageFather = $page;
        $thisdata->pageConf->idRegister = $id;
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page);
        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 1);
        return view('Admin.upload')->with('thisdata', $thisdata);
    }

    // Abre página de carregamento de arquivos
    public function uploadindexfile($page, $id)
    {
        $thisdata = new \stdClass;
        $thisdata->pageConf = $this->pageConf;
        $thisdata->pageConf->pageFather = $page;
        $thisdata->pageConf->idRegister = $id;
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page);
        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 2);
        return view('Admin.uploadfile')->with('thisdata', $thisdata);
    }

    // Abre página de carregamento de videos
    public function uploadindexvideo($page, $id)
    {
        $thisdata = new \stdClass;
        $thisdata->pageConf = $this->pageConf;
        $thisdata->pageConf->pageFather = $page;
        $thisdata->pageConf->idRegister = $id;
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page);
        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 3);
        return view('Admin.uploadvideo')->with('thisdata', $thisdata);
    }

    // Abre página de carregamento mobile
    public function uploadindexmobile($page, $id)
    {
        $thisdata = new \stdClass;
        $thisdata->pageConf = $this->pageConf;
        $thisdata->pageConf->pageFather = $page;
        $thisdata->pageConf->idRegister = $id;
        $thisdata->pageConf->pageFatherId = $this->getFatherId($page);
        $thisdata->uploadList = $this->getUploadList($thisdata->pageConf->pageFatherId, $id, 4);
        return view('Admin.uploadmobile')->with('thisdata', $thisdata);
    }

    // Função que seta caminho de cada arquivo
    private function getUrlFile($uploads)
    {
        $uploads_path = url('/uploads');
        foreach ($uploads as $key => $upload) {
            $path_menu = md5($upload->id_menu);
            $path_id   = md5($upload->id_register);
            $uploads[$key]->imageFolder = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;
        }
        return $uploads;
    }

    // Função que pega a lista de uploads do menu
    private function getUploadList($idMenu, $idRegister, $type, $thumb = NULL)
    {
        $uploads = DB::table('vpr_nav_group_menu_upload as upload')
            ->where('upload.id_menu', $idMenu)
            ->where('upload.id_type', $type)
            ->where('upload.id_register', $idRegister)
            ->where('upload.delete', false)
            ->where('upload.status', true)
            ->orderBy('order', 'ASC')
            ->get();
        return $this->getUrlFile($uploads, $thumb);
    }

    // Pega todas as thumbnails da página
    private function getThumbnails($pageFatherId)
    {
        return DB::table('vpr_nav_group_menu_thumb')
            ->where('id_menu', $pageFatherId)
            ->where('delete', false)
            ->where('status', true)
            ->get();
    }

    // Verifica e cria pastas de upload
    private function uploadsPathCheck($pageFatherId, $registerId, $thumbnails)
    {
        if (!is_dir($this->uploads_path)) {
            mkdir($this->uploads_path, 0775, true);
        }

        $name_path             = md5($pageFatherId);
        $path_root_thiscontent = $this->uploads_path . '/' . $name_path;
        if (!is_dir($path_root_thiscontent)) {
            mkdir($path_root_thiscontent, 0775, true);
        }

        $name_path_register        = md5($registerId);
        $path_register_thiscontent = $path_root_thiscontent . '/' . $name_path_register;
        if (!is_dir($path_register_thiscontent)) {
            mkdir($path_register_thiscontent, 0775, true);
        }

        foreach ($thumbnails as $thumb) {
            $path_thumb = $path_register_thiscontent . '/' . $thumb->storange_name;
            if (!is_dir($path_thumb)) {
                mkdir($path_thumb, 0775, true);
            }
        }
    }

    private function setNameSalve($nameOriginal)
    {
        $nameOriginal      = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($nameOriginal)));
        $nameOriginal      = preg_replace("/[^ \w\-.]+/", "", $nameOriginal);
        $nameNoCharracters = str_replace(" ", "-", $nameOriginal);
        return md5(date("Ymdhsi") . $nameNoCharracters);
    }

    // Salva thumbnails da imagem
    private function saveImgeThumb($file, $thumbnails, $filevar, $path_thiscontent)
    {
        foreach ($thumbnails as $thumb) {
            $configThumb         = new \stdClass;
            $configThumb->folder = $path_thiscontent . '/' . $thumb->storange_name;

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
     * Saving images uploaded through XHR Request (com chunk).
     */
    public function save(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        $thumbnails = $this->getThumbnails($pageFatherId);
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        $fileReceiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if ($fileReceiver->isUploaded() === false) {
            return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 200);
        }

        $save = $fileReceiver->receive();

        // Ainda recebendo chunks — retorna progresso
        if (!$save->isFinished()) {
            return Response::json([
                'done'   => $save->handler()->getPercentageDone(),
                'status' => true,
            ], 200);
        }

        // Upload completo — processa imagem
        $file = $save->getFile();

        $filevar                      = new \stdClass;
        $filevar->nameOriginal        = $file->getClientOriginalName();
        $filevar->extencionOriginal   = $file->getClientOriginalExtension();
        $filevar->nameForSave         = $this->setNameSalve($filevar->nameOriginal) . '.webp';
        if ($filevar->extencionOriginal == 'gif') {
            $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.gif';
        }
        $filevar->descriptionOriginal = $file->getClientOriginalName();
        $filevar->author              = '';
        $filevar->direct              = '';

        $name_path          = md5($pageFatherId);
        $name_path_register = md5($registerId);
        $path_thiscontent   = $this->uploads_path . '/' . $name_path . '/' . $name_path_register;

        $guardFileOriginal = Image::make($file->getRealPath())->encode('webp');
        if ($filevar->extencionOriginal == 'gif') {
            $guardFileOriginal = Image::make($file->getRealPath())->encode('gif');
        }

        if ($guardFileOriginal->save($path_thiscontent . '/' . $filevar->nameForSave)) {

            if ($this->saveImgeThumb($file->getRealPath(), $thumbnails, $filevar, $path_thiscontent)) {

                @unlink($file->getRealPath());

                $upload               = new Upload();
                $upload->id_menu      = $pageFatherId;
                $upload->id_register  = $registerId;
                $upload->id_type      = 1;
                $upload->extension    = $filevar->extencionOriginal;
                $upload->name         = $filevar->nameForSave;
                $upload->description  = $filevar->descriptionOriginal;
                $upload->author       = $filevar->author;
                $upload->image_rights = $filevar->direct;
                $upload->order        = 1;
                $upload->save();

                return Response::json(['message' => 'Image saved Successfully'], 200);
            }
        }

        return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 200);
    }

    /**
     * Saving mobile images uploaded through XHR Request (com chunk).
     */
    public function savemobile(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        $thumbnails = $this->getThumbnails($pageFatherId);
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        $fileReceiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if ($fileReceiver->isUploaded() === false) {
            return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 200);
        }

        $save = $fileReceiver->receive();

        // Ainda recebendo chunks — retorna progresso
        if (!$save->isFinished()) {
            return Response::json([
                'done'   => $save->handler()->getPercentageDone(),
                'status' => true,
            ], 200);
        }

        // Upload completo — processa imagem
        $file = $save->getFile();

        $filevar                      = new \stdClass;
        $filevar->nameOriginal        = $file->getClientOriginalName();
        $filevar->extencionOriginal   = $file->getClientOriginalExtension();
        $filevar->nameForSave         = $this->setNameSalve($filevar->nameOriginal) . '.webp';
        if ($filevar->extencionOriginal == 'gif') {
            $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.gif';
        }
        $filevar->descriptionOriginal = $file->getClientOriginalName();
        $filevar->author              = '';
        $filevar->direct              = '';

        $name_path          = md5($pageFatherId);
        $name_path_register = md5($registerId);
        $path_thiscontent   = $this->uploads_path . '/' . $name_path . '/' . $name_path_register;

        $guardFileOriginal = Image::make($file->getRealPath())->encode('webp');
        if ($filevar->extencionOriginal == 'gif') {
            $guardFileOriginal = Image::make($file->getRealPath())->encode('gif');
        }

        if ($guardFileOriginal->save($path_thiscontent . '/' . $filevar->nameForSave)) {

            if ($this->saveImgeThumb($file->getRealPath(), $thumbnails, $filevar, $path_thiscontent)) {

                @unlink($file->getRealPath());

                $upload               = new Upload();
                $upload->id_menu      = $pageFatherId;
                $upload->id_register  = $registerId;
                $upload->id_type      = 4;
                $upload->extension    = $filevar->extencionOriginal;
                $upload->name         = $filevar->nameForSave;
                $upload->description  = $filevar->descriptionOriginal;
                $upload->author       = $filevar->author;
                $upload->image_rights = $filevar->direct;
                $upload->order        = 1;
                $upload->save();

                return Response::json(['message' => 'Image saved Successfully'], 200);
            }
        }

        return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 200);
    }

    /**
     * Saving Files uploaded through XHR Request (com chunk).
     */
    public function savefile(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        $file       = $request->file('file');
        $thumbnails = $this->getThumbnails($pageFatherId);
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        if (!is_array($file)) {

            $fileReceiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

            if ($fileReceiver->isUploaded() === false) {
                return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 200);
            }

            $save = $fileReceiver->receive();

            if ($save->isFinished()) {

                $unChunkedFile = $save->getFile();

                $filevar                      = new \stdClass;
                $filevar->nameOriginal        = $unChunkedFile->getClientOriginalName();
                $filevar->extencionOriginal   = $unChunkedFile->getClientOriginalExtension();
                $filevar->descriptionOriginal = $unChunkedFile->getClientOriginalName();
                $filevar->author              = '';
                $filevar->direct              = '';
                $filevar->mimeType            = $unChunkedFile->getMimeType();

                $name_path          = md5($pageFatherId);
                $name_path_register = md5($registerId);
                $fileName           = md5($filevar->nameOriginal);
                $path_thiscontent   = $name_path . '/' . $name_path_register . '/' . $fileName . '.' . $filevar->extencionOriginal;
                $path_thiscontent   = Storage::disk('uploads')->path('') . $path_thiscontent;

                File::move($unChunkedFile->getRealPath(), $path_thiscontent);

                $upload               = new Upload();
                $upload->id_menu      = $pageFatherId;
                $upload->id_register  = $registerId;
                $upload->id_type      = 2;
                $upload->extension    = $filevar->extencionOriginal;
                $upload->name         = $this->getRealNameUpload($path_thiscontent);
                $upload->description  = $filevar->descriptionOriginal;
                $upload->author       = $filevar->author;
                $upload->image_rights = $filevar->direct;
                $upload->order        = 1;
                $upload->save();

                return Response::json(['message' => 'File saved Successfully'], 200);
            }

            $handler = $save->handler();

            return Response::json([
                'done'   => $handler->getPercentageDone(),
                'status' => true,
            ], 200);
        }
    }

    /**
     * Saving videos uploaded through XHR Request (com chunk).
     */
    public function savevideo(Request $request, $pageFatherId, $registerId)
    {
        $name = Navgroupmenu::select('link')->find($request->segment(3));
        Cache::forget($name->link);

        $file       = $request->file('file');
        $thumbnails = $this->getThumbnails($pageFatherId);
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        if (!is_array($file)) {

            $fileReceiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

            if ($fileReceiver->isUploaded() === false) {
                return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 200);
            }

            $save = $fileReceiver->receive();

            if ($save->isFinished()) {

                $unChunkedFile = $save->getFile();

                $filevar                      = new \stdClass;
                $filevar->nameOriginal        = $unChunkedFile->getClientOriginalName();
                $filevar->extencionOriginal   = $unChunkedFile->getClientOriginalExtension();
                $filevar->descriptionOriginal = $unChunkedFile->getClientOriginalName();
                $filevar->author              = '';
                $filevar->direct              = '';
                $filevar->mimeType            = $unChunkedFile->getMimeType();

                $name_path          = md5($pageFatherId);
                $name_path_register = md5($registerId);
                $fileName           = md5($filevar->nameOriginal);
                $path_thiscontent   = $name_path . '/' . $name_path_register . '/' . $fileName . '.' . $filevar->extencionOriginal;
                $path_thiscontent   = Storage::disk('uploads')->path('') . $path_thiscontent;

                File::move($unChunkedFile->getRealPath(), $path_thiscontent);

                $upload               = new Upload();
                $upload->id_menu      = $pageFatherId;
                $upload->id_register  = $registerId;
                $upload->id_type      = 3;
                $upload->extension    = $filevar->extencionOriginal;
                $upload->name         = $this->getRealNameUpload($path_thiscontent);
                $upload->description  = $filevar->descriptionOriginal;
                $upload->author       = $filevar->author;
                $upload->image_rights = $filevar->direct;
                $upload->order        = 1;
                $upload->save();

                return Response::json(['message' => 'File saved Successfully'], 200);
            }

            $handler = $save->handler();

            return Response::json([
                'done'   => $handler->getPercentageDone(),
                'status' => true,
            ], 200);
        }
    }

    public function deleteUpload($id)
    {
        $fileId          = $id;
        $upload_register = $this->_model::where('id_upload', $fileId)->get();
        $response        = new \stdClass;

        $path_menu  = md5($upload_register[0]->id_menu);
        $path_id    = md5($upload_register[0]->id_register);
        $file_name  = $upload_register[0]->name;
        $id_menu    = $upload_register[0]->id_menu;
        $file_path  = $this->uploads_path . '/' . $path_menu . '/' . $path_id . '/';
        $fileUnlink = $file_path . $file_name;

        if ($this->_model::where('id_upload', $fileId)->update(['delete' => true])) {

            if (file_exists($fileUnlink)) {
                unlink($fileUnlink);
            }

            $thumbs = DB::table('vpr_nav_group_menu_thumb')
                ->where('id_menu', $id_menu)
                ->where('delete', false)
                ->where('status', true)
                ->get();

            foreach ($thumbs as $thumb) {
                $fileThumbUnlink = $file_path . $thumb->storange_name . '/' . $file_name;
                if (file_exists($fileThumbUnlink)) {
                    unlink($fileThumbUnlink);
                }
            }

            $name = Navgroupmenu::select('link')->find($upload_register[0]->id_menu);
            Cache::forget($name->link);

            $response->status  = 'true';
            $response->message = 'Deletado com sucesso';
        } else {
            $response->status  = 'error';
            $response->message = 'Erro! Registros não puderam ser deletados!';
        }
        echo json_encode($response);
    }

    public function sortable(Request $request)
    {
        foreach ($request->ordem as $ordenar) {
            $updateorder        = Upload::find($ordenar['id_upload']);
            $updateorder->order = $ordenar['order'];
            $updateorder->save();
        }
        return 'true';
    }

    public function galleryUpload(Request $request, $pageFatherId)
    {
        $registerId = '9999';

        $name = Navgroupmenu::select('link')->find($request->segment(4));
        Cache::forget($name->link);

        $file       = $request->file('file');
        $thumbnails = $this->getThumbnails($pageFatherId);
        $this->uploadsPathCheck($pageFatherId, $registerId, $thumbnails);

        if (!is_array($file)) {

            $filevar                      = new \stdClass;
            $filevar->nameOriginal        = $file->getClientOriginalName();
            $filevar->extencionOriginal   = $file->getClientOriginalExtension();
            $filevar->nameForSave         = $this->setNameSalve($filevar->nameOriginal) . '.webp';
            if ($filevar->extencionOriginal == 'gif') {
                $filevar->nameForSave = $this->setNameSalve($filevar->nameOriginal) . '.' . $filevar->extencionOriginal;
            }
            $filevar->descriptionOriginal = $file->getClientOriginalName();
            $filevar->author              = '';
            $filevar->direct              = '';
            $filevar->mimeType            = $file->getMimeType();

            $name_path          = md5($pageFatherId);
            $name_path_register = md5($registerId);
            $path_thiscontent   = $this->uploads_path . '/' . $name_path . '/' . $name_path_register;

            $guardFileOriginal = Image::make($file);
            if ($filevar->extencionOriginal == 'gif') {
                $guardFileOriginal = Image::make($file)->encode('gif');
            }

            if ($guardFileOriginal->save($path_thiscontent . '/' . $filevar->nameForSave)) {

                if ($this->saveImgeThumb($file, $thumbnails, $filevar, $path_thiscontent)) {

                    $upload               = new Upload();
                    $upload->id_menu      = $pageFatherId;
                    $upload->id_register  = $registerId;
                    $upload->id_type      = 1;
                    $upload->extension    = $filevar->extencionOriginal;
                    $upload->name         = $filevar->nameForSave;
                    $upload->description  = $filevar->descriptionOriginal;
                    $upload->author       = $filevar->author;
                    $upload->image_rights = $filevar->direct;
                    $upload->order        = 1;
                    $upload->save();
                    $upload->refresh();

                    $uploads_path = url('/uploads');
                    $path_menu    = md5($upload->id_menu);
                    $path_id      = md5($upload->id_register);
                    $url          = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;

                    return Response::json([
                        'message' => 'Image saved Successfully',
                        'data'    => [
                            'idUpload' => $upload->id_upload,
                            'imgUrl'   => $url,
                        ],
                    ], 200);
                }
            }
        } else {
            return Response::json(['message' => 'IncorrectSendFile', 'code' => '100'], 500);
        }
    }

    public function galleryPage(Request $request, $menu, $page)
    {
        $upload = DB::table('vpr_nav_group_menu_upload as upload')
            ->select(['id_upload', 'id_menu', 'id_register', 'name'])
            ->where('upload.id_menu', $menu)
            ->where('upload.id_register', '9999')
            ->where('upload.delete', false)
            ->where('upload.status', true)
            ->orderby('id_upload', 'DESC')
            ->skip(($page - 1) * 3)
            ->take(3)
            ->get();

        $uploads_path = url('/uploads');

        if ($upload->isEmpty()) {
            return Response::json([
                'success' => false,
                'message' => 'empty query',
                'data'    => null,
            ], '200');
        }

        foreach ($upload as $key => $upload) {
            $path_menu = md5($upload->id_menu);
            $path_id   = md5($upload->id_register);
            $url       = $uploads_path . '/' . $path_menu . '/' . $path_id . '/' . $upload->name;

            $returnData[] = [
                'idUpload' => $upload->id_upload,
                'imgUrl'   => $url,
            ];
        }

        return Response::json(['success' => true, 'data' => $returnData], 200);
    }
}