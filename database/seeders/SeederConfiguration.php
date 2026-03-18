<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederConfiguration extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('vpr_configuration')->count() == 0){
            DB::table('vpr_configuration')->insert([
                [
                    'id_configuration' => 1,
                    'name' => 'Nome do Website',
                    'keywords' => 'Palavras Chave',
                    'analytics' => 'Codigo Analicts',
                    'mail' => 'Email Que recebe contatos do site'
                ]
            ]);
        }
    }
}
