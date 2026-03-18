<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Request;
use \Rap2hpoutre\LaravelLogViewer\LogViewerController;


class LogHistoryController extends Controller
{

    private $patterns = [
        'logs' => '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/',
        'current_log' => [
            '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
            ': (.*?)( in .*?:[0-9]+)?$/i'
        ],
        'files' => '/\{.*?\,.*?\}/i',
    ];

    private $levels = [
        'debug',
        'info',
        'notice',
        'warning',
        'error',
        'critical',
        'alert',
        'emergency',
        'processed',
        'failed'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_model = Navgroup::class; // Declaração do Model da página
        $this->pageConf = new \stdClass; //Inicia objeto com dados da pag.
        $this->pageConf->pageData = $this->getPageData(); //Pena de forma automatica dados da pagina da tabela configurada no Model
        $this->pageConf->pageFather = "null"; //Pega link da pag. pai ('informar null caso nao tenha pag. pai')
        $this->pageConf->pageChildren = $this->getPageChildren(); //Pega o submenu de cadastro
        // $pageConf->getSearch = $this->getPageChildren();                               //Pega o submenu de cadastro
    }

    public function index(Request $request)
    {
        $thisdata = new \stdClass;
        $thisdata->pageConf = $this->pageConf;


        // from PHP documentations

        $logFiles = glob(storage_path() . '/logs/actions.log');

        foreach ($logFiles as $logfile) {
            if (!is_readable($logfile)) {
                continue;
            }
            $logName = array_last(explode('/', $logfile));

            $logfile = app('files')->get($logfile);

    
            preg_match_all($this->patterns['logs'], $logfile, $headings);

            $log_data = preg_split($this->patterns['logs'], $logfile);

            if ($log_data[0] < 1) {
                array_shift($log_data);
            }

            foreach ($headings as $h) {
                for ($i = 0, $j = count($h); $i < $j; $i++) {
                    foreach ($this->levels as $level) {
                        if (strpos(strtolower($h[$i]), '.' . $level) || strpos(strtolower($h[$i]), $level . ':')) {

                            preg_match($this->patterns['current_log'][0] . $level . $this->patterns['current_log'][1], $h[$i], $current);
                            
                            if (!isset($current[4])) {
                                continue;
                            }

                            $logArray = [
                                'context' => $current[3],
                                'level' => $level,
                                'date' => date('d/m/Y H:i:s',strtotime($current[1])),
                                'text' => $current[4],
                                'stack' => preg_replace("/^\n*/", '', $log_data[$i])
                            ];

                            $logs[$logName][] = $logArray;
                        }
                    }
                }
            }
        }

        $thisdata->logs = $logs;

        return view('Admin.Pages.viewlogs', ['thisdata' => $thisdata]);
    }
}