<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // check if table vpr_permission is empty
         if(DB::table('vpr_permission')->count() == 0){
            DB::table('vpr_permission')->insert([
                ['id_menu' => 1, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 2, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 3, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 4, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 5, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 6, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 7, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 8, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 9, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 10, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 11, 'id_group' => 1, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 12, 'id_group' => 2, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 13, 'id_group' => 2, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 14, 'id_group' => 2, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
                ['id_menu' => 15, 'id_group' => 2, 'id_user' => 1, 'view' => 1, 'edit' => 1, 'add' => 1, 'upload' => 1, 'delete' => 1, 'status' => 1],
            ]);
        }
    }
}