<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederNavGroupMenuStyleCollumns extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        // check if table vpr_nav_group_menu_style_collumns is empty
        if(DB::table('vpr_nav_group_menu_style_collumns')->count() == 0){
            DB::table('vpr_nav_group_menu_style_collumns')->insert([
                ['id_menu_style' => 1, 'name' => 'ID', 'collumn' => 'id_nav_group', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 1, 'name' => 'Nome Do Grupo', 'collumn' => 'name', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 1, 'name' => 'Link', 'collumn' => 'link', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 30],
                ['id_menu_style' => 1, 'name' => 'Criado em:', 'collumn' => 'created_at', 'default' => 0, 'order' => 'desc', 'function' => 0, 'legenth' => 0, 'size' => 20],
                ['id_menu_style' => 2, 'name' => 'Id', 'collumn' => 'id_nav_group_menu', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 2, 'name' => 'Nome Do Menu', 'collumn' => 'name', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 50],
                ['id_menu_style' => 2, 'name' => 'Link', 'collumn' => 'link', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 3, 'name' => 'Id', 'collumn' => 'id_login_user', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 3, 'name' => 'Nome do Usuário', 'collumn' => 'name', 'default' => 0, 'order' => 'null', 'function' => 0, 'legenth' => 250, 'size' => 40],
                ['id_menu_style' => 3, 'name' => 'E-mail', 'collumn' => 'email', 'default' => 0, 'order' => 'null', 'function' => 0, 'legenth' => 250, 'size' => 50],
                ['id_menu_style' => 4, 'name' => 'ID', 'collumn' => 'id_login_user', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'ID', 'collumn' => 'id_permission', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Menu', 'collumn' => 'id_menu', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Grupo', 'collumn' => 'id_grupo', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Perm. Visualizar', 'collumn' => 'view', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Perm. Editar', 'collumn' => 'edit', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Perm. Adicionar', 'collumn' => 'add', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Perm. Delete', 'collumn' => 'delete', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 5, 'name' => 'Perm. Upar', 'collumn' => 'upload', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 6, 'name' => 'ID', 'collumn' => 'id_menu_children', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 6, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 7, 'name' => 'ID', 'collumn' => 'id_menu_style', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 7, 'name' => 'Default', 'collumn' => 'default', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 30],
                ['id_menu_style' => 7, 'name' => 'Estilo', 'collumn' => 'id_style', 'default' => 0, 'order' => 'asc', 'function' => 1, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 8, 'name' => 'ID', 'collumn' => 'id_configuration', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 8, 'name' => 'SMTP', 'collumn' => 'smtp', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 8, 'name' => 'E-mail de Envio', 'collumn' => 'mail_send', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 8, 'name' => 'Porta SMTP', 'collumn' => 'smtp_port', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 9, 'name' => 'ID', 'collumn' => 'id_menu_style_list', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 9, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 9, 'name' => 'Coluna', 'collumn' => 'collumn', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 40],
                ['id_menu_style' => 9, 'name' => 'Default', 'collumn' => 'default', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 10, 'name' => 'ID', 'collumn' => 'id_thumb', 'default' => 1, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 10],
                ['id_menu_style' => 10, 'name' => 'Largura', 'collumn' => 'width', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 30],
                ['id_menu_style' => 10, 'name' => 'Altura', 'collumn' => 'height', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 30],
                ['id_menu_style' => 10, 'name' => 'Cortar em', 'collumn' => 'cut', 'default' => 0, 'order' => 'asc', 'function' => 0, 'legenth' => 0, 'size' => 30],
                ['id_menu_style' => 11, 'name' => 'ID', 'collumn' => 'id_configuration', 'default' => 1, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 10],
                ['id_menu_style' => 11, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 15],
                ['id_menu_style' => 11, 'name' => 'Palavras Chave', 'collumn' => 'keywords', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 30],
                ['id_menu_style' => 11, 'name' => 'Codigo Google', 'collumn' => 'analytics', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 15],
                ['id_menu_style' => 11, 'name' => 'E-mail', 'collumn' => 'mail', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 30],

                ['id_menu_style' => 12, 'name' => 'ID', 'collumn' => 'id_text', 'default' => 1, 'order' => 'ASC', 'function' => 0, 'legenth' => 10, 'size' => 10],
                ['id_menu_style' => 12, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 50],
                ['id_menu_style' => 12, 'name' => 'Slug', 'collumn' => 'info_location', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 40],

                ['id_menu_style' => 13, 'name' => 'ID', 'collumn' => 'id_textbusiness', 'default' => 1, 'order' => 'ASC', 'function' => 0, 'legenth' => 10, 'size' => 10],
                ['id_menu_style' => 13, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 50],
                ['id_menu_style' => 13, 'name' => 'Slug', 'collumn' => 'info_location', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 150, 'size' => 40],

                ['id_menu_style' => 14, 'name' => 'ID', 'collumn' => 'id_banner', 'default' => 1, 'order' => 'ASC', 'function' => 0, 'legenth' => 10, 'size' => 10],
                ['id_menu_style' => 14, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 200, 'size' => 40],
                ['id_menu_style' => 14, 'name' => 'Link', 'collumn' => 'link', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 200, 'size' => 40],
                ['id_menu_style' => 14, 'name' => 'Ordenação', 'collumn' => 'order', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 10, 'size' => 10],

                ['id_menu_style' => 15, 'name' => 'ID', 'collumn' => 'id_police', 'default' => 1, 'order' => 'ASC', 'function' => 0, 'legenth' => 10, 'size' => 10],
                ['id_menu_style' => 15, 'name' => 'Nome', 'collumn' => 'name', 'default' => 0, 'order' => 'ASC', 'function' => 0, 'legenth' => 200, 'size' => 90],
            ]);
        }
    }
}
