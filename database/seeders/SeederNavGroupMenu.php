<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederNavGroupMenu extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    // check if table vpr_nav_group_menu is empty
    if(DB::table('vpr_nav_group_menu')->count() == 0){
      DB::table('vpr_nav_group_menu')->insert([
        ['id_group' => 1, 'name' => 'Grupos de Menus', 'link' => 'navgroup', 'visible' => 1],
        ['id_group' => 1, 'name' => 'Menus', 'link' => 'navgroupmenu', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Usuarios', 'link' => 'usuarios', 'visible' => 1],
        ['id_group' => 1, 'name' => 'Aleração de Senha', 'link' => 'usuariopassword', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Permissões', 'link' => 'permissoes', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Conf. menu Filho', 'link' => 'navmenuchildren', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Conf. Menu Style', 'link' => 'navmenustyle', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Conf. Email Envio', 'link' => 'mailconfig', 'visible' => 1],
        ['id_group' => 1, 'name' => 'Conf. Menu Style Colunas', 'link' => 'navgroupmenustylecollumn', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Thumb', 'link' => 'thumb', 'visible' => 0],
        ['id_group' => 1, 'name' => 'Configurações', 'link' => 'configuration', 'visible' => 1],

        ['id_group' => 2, 'name' => 'Textos Fixos', 'link' => 'texts', 'visible' => 1],
        ['id_group' => 2, 'name' => 'Textos Empresa', 'link' => 'textbusiness', 'visible' => 1],
        ['id_group' => 2, 'name' => 'Banners', 'link' => 'banners', 'visible' => 1],
        ['id_group' => 2, 'name' => 'Políticas', 'link' => 'polices', 'visible' => 1],

      ]);
    }
  }
}
