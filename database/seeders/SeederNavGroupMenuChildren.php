<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederNavGroupMenuChildren extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        // check if table vpr_nav_group_menu_children is empty
        if(DB::table('vpr_nav_group_menu_children')->count() == 0){
            DB::table('vpr_nav_group_menu_children')->insert([
                ['id_menu' => 1, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 1, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 1, 'name' => 'Menus', 'link' => 'navgroupmenu', 'default' => 0],
                ['id_menu' => 2, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 2, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 2, 'name' => 'Thumb', 'link' => 'thumb', 'default' => 0],
                ['id_menu' => 2, 'name' => 'Conf__Filhos', 'link' => 'navmenuchildren', 'default' => 0],
                ['id_menu' => 2, 'name' => 'Conf__Busca', 'link' => 'navmenusearch', 'default' => 0],
                ['id_menu' => 2, 'name' => 'Conf__Style', 'link' => 'navmenustyle', 'default' => 0],
                ['id_menu' => 3, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 3, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 3, 'name' => 'Alerar_Senha', 'link' => 'usuariopassword', 'default' => 0],
                ['id_menu' => 3, 'name' => 'Permissões', 'link' => 'permissoes', 'default' => 0],
                ['id_menu' => 4, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 4, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 5, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 5, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 6, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 6, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 7, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 7, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 7, 'name' => 'Lista_Colunas', 'link' => 'navgroupmenustylecollumn', 'default' => 0],
                ['id_menu' => 8, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 8, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 9, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 9, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 10, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 10, 'name' => 'Uploads', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 11, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 11, 'name' => 'Upload', 'link' => 'upload', 'default' => 0],

                ['id_menu' => 12, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 12, 'name' => 'Upload', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 13, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 13, 'name' => 'Upload', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 14, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 14, 'name' => 'Upload', 'link' => 'upload', 'default' => 0],
                ['id_menu' => 15, 'name' => 'Geral', 'link' => '', 'default' => 1],
                ['id_menu' => 15, 'name' => 'Upload', 'link' => 'upload', 'default' => 0],
                
            ]);
        }
    }
}