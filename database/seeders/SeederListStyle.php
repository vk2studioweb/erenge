<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederListStyle extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        // check if table vpr_list_style is empty
        if(DB::table('vpr_list_style')->count() == 0){
            DB::table('vpr_list_style')->insert([
                ['name' => 'Lista', 'file' => 'listLines'],
                ['name' => 'Lista com Imagem', 'file' => 'listLineImages'],
                ['name' => 'Imagem', 'file' => 'listImages'],
                ['name' => 'Permissões', 'file' => 'permissoes'],
                ['name' => 'Collunas p/ Stilo', 'file' => 'menustylecollumn'],
                ['name' => 'Gerenciamento', 'file' => 'management']
            ]);
        }
    }
}
