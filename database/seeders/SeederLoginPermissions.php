<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederLoginPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // check if table vpr_login_permissions is empty
         if(DB::table('vpr_login_permissions')->count() == 0){
            DB::table('vpr_login_permissions')->insert([
                ['name' => 'Administrador'],
                ['name' => 'Usuário'],
            ]);
        }
    }
}
