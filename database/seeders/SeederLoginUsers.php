<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederLoginUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table vpr_login_users is empty
        if(DB::table('vpr_login_users')->count() == 0){
            DB::table('vpr_login_users')->insert([
                ['id_class' => 1, 'id_permission' => 1, 'name' => 'Suporte Vk2', 'email' => 'suporte@vk2.com.br', 'password' => '$2y$10$6P5GTlDbEfEO.yZiFgj04.Xz9A.Ifs9GWqm4s2bplUdO86Ms0.i4S', 'remember_token' => 'LvExiXPAESUUFzjZ9z57E1Bql3IXYpytCUNDvjdt2rx9Zi1snSPf4Vvzcdv8'],

            ]);
        }
    }
}
