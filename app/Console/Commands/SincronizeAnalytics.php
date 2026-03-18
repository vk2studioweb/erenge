<?php

namespace App\Console\Commands;

use App\Models\Admin\AnalyticsCalls;
use App\Models\Admin\AnalyticsDados;
use App\Models\Admin\AnalyticsConnects;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DateTime;
use Carbon\Carbon;
use \Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

class SincronizeAnalytics extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'sincronize:analytics';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Comando de sincronização do analytics, serve para pegar os dados do analytics para e salvar no banco';
    
    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $log = "Success";
        $date = Carbon::today();
        $period = Period::months(1);
        
        $callbacks = AnalyticsCalls::where('status', 1)->where('delete', 0)->get();
        $sincronize = new AnalyticsConnects;
        $sincronize->date = $date;
        $sincronize->log = $log;
        if($sincronize->save()){
            $id_analytics_connect = $sincronize->id_analytics_connect;

            foreach($callbacks as $item){
                if($item->name == "visitor"){
                    $data = Analytics::fetchVisitorsAndPageViews($period);
                }
                if($item->name == "total"){
                    $data = Analytics::fetchTotalVisitorsAndPageViews($period);
                }
                if($item->name == "most"){
                    $data = Analytics::fetchMostVisitedPages($period);
                }
                if($item->name == "top"){
                    $data = Analytics::fetchTopReferrers($period);
                }
                if($item->name == "browsers"){
                    $data = Analytics::fetchTopBrowsers($period);
                }

                foreach($data as $key=>$item2){
                    foreach($item2 as $key2=>$item3){
                        $analyticsDados = new AnalyticsDados;
                        $analyticsDados->id_analytics_call = $item->id_analytics_call;
                        $analyticsDados->id_analytics_connect = $id_analytics_connect;
                        $analyticsDados->name = $key2;
                        $analyticsDados->value = $item3;
                        $analyticsDados->array = $key;
                        if(!$analyticsDados->save()){
                            Log::error($item->name.' - '.$key2.' - '.$key);
                        }
                    }
                }
            }
            Log::info('Analytics Sincronizado');
        } else {
            Log::info("Erro ao salvar a data de sincronização");
        }
        
    }
}
