<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederLoginClasses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table vpr_login_classes is empty
        if(DB::table('vpr_login_classes')->count() == 0){
            DB::table('vpr_login_classes')->insert([
                ['name' => 'Admin'],
                ['name' => 'Site'],
            ]);
        }
    }
}
