<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederNavGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('vpr_nav_group')->count() == 0){
            DB::table('vpr_nav_group')->insert([
              ['name' => 'Configurações', 'submenu' => 1],
              ['name' => 'Informações Site', 'submenu' => 1],
              ['name' => 'Ecommerce', 'submenu' => 1]
            ]);
          }
    }
}
