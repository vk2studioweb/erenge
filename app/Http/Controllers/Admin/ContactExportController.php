<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Newsletter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datetime;
use DB;
use Illuminate\Support\Facades\Route;

class ContactExportController extends Controller
{

    const CONTACT_MODELS = [
        'Newsletter' => [
            'model' => Newsletter::class,
            'columns' => [
                'name',
                'email',
            ]
        ],
    ];

    private $pageConf;

    private $pageData;
    public function __construct()
    {
        //Inicia objeto com dados da pag.
        $this->pageConf = new \stdClass;
        //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageData = $this->getPageData();
        //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageFather = "null";
        //Chave Estrangeira do pai para criar SQL
        $this->pageConf->collunIdFather = "[id_do_pai]";
        //Pega o submenu de cadastro
        $this->pageConf->pageChildren = $this->getPageChildren();
    }


    public function index()
    {

        $thisdata = new \stdClass; // Variavel responsavel por receber dados para passar para o usuario
        $thisdata->pageConf = $this->pageConf; //Resgata dados de configuraçao e caregamento da pag. e aplica na variavel de carregamento


        $thisdata->models = $this->getModelsSelect();


        return view('Admin.Pages.contactExport')->with('thisdata', $thisdata);
    }
    public function getModelsSelect()
    {
        $modelSelect = array_keys(self::CONTACT_MODELS);

        foreach ($modelSelect as $key => $model) {
            unset($modelSelect[$key]);

            $modelSelect[$model] = $model;
        }

        return $modelSelect;
    }

    public function getContacts(Request $request)
    {
        $_model = self::CONTACT_MODELS[$request['model']]['model'];

        $contactModel = new $_model();

        $query = $contactModel::query();

        $query->when(request('exportType') == 'last7Days', function ($q) {
            return $q->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()]);
        });


        if ($request['dateCheck']) {

            $contactStartDate = Carbon::parse($request['contacts_start'])->format('Y-m-d');
            $contactEndDate = Carbon::parse($request['contacts_end'])->format('Y-m-d');

            if ($contactEndDate < $contactStartDate) {
                return 'Data Final não pode ser menor que data Inicial <br> <a href="#" onclick="window.close();return false;">FECHAR</a>';
            }

            $query->whereBetween('created_at', [$contactStartDate, $contactEndDate]);
        }

        $query->when(request('onlyNewRegisters') == 1, function ($q) {
            return $q->where('download', 0);
        });

        try {

            $fileName = $request['model'] . "-" . Carbon::now()->format('Y-m-d');

            $columns = self::CONTACT_MODELS[$request['model']]['columns'];

            $primaryKey = app(self::CONTACT_MODELS[$request['model']]['model'])->getKeyName();

            array_unshift($columns, $primaryKey);

            $result = $query->where('status', 1)->where('delete', 0)->get($columns);

            if ($result->count() == 0) {
                return 'resultado vazio, verifique os filtros <br> <a href="#" onclick="window.close();return false;">FECHAR</a>';
            }

            $contactModel::whereIn($primaryKey, $result->pluck($primaryKey))->update(['download' => 1]);

            $callback = function () use ($result, $columns, $contactModel) {

                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                $chunkedResult = $result->chunk(50);

                $chunkedResult->each(function ($collection) use ($file) {
                    $collection->each(function ($item) use ($file) {
                        fputcsv($file, $item->toArray());
                    });
                });

                fclose($file);
            };

            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            return response()->stream($callback, 200, $headers);

        } catch (\Throwable $th) {
            return 'Erro no retorno do arquivo <br> <a href="#" onclick="window.close();return false;">FECHAR</a>';
        }

    }
}