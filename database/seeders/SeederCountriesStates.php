<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederCountriesStates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vpr_countries_states')->insert([
            ['id_country' => 1, 'name' => 'Acre', 'uf' => 'AC'],
            ['id_country' => 1, 'name' => 'Alagoas', 'uf' => 'AL'],
            ['id_country' => 1, 'name' => 'Amapá', 'uf' => 'AP'],
            ['id_country' => 1, 'name' => 'Amazonas', 'uf' => 'AM'],
            ['id_country' => 1, 'name' => 'Bahia', 'uf' => 'BA'],
            ['id_country' => 1, 'name' => 'Ceará', 'uf' => 'CE'],
            ['id_country' => 1, 'name' => 'Distrito Federal', 'uf' => 'DF'],
            ['id_country' => 1, 'name' => 'Espírito Santo', 'uf' => 'ES'],
            ['id_country' => 1, 'name' => 'Goiás', 'uf' => 'GO'],
            ['id_country' => 1, 'name' => 'Maranhão', 'uf' => 'MA'],
            ['id_country' => 1, 'name' => 'Mato Grosso', 'uf' => 'MT'],
            ['id_country' => 1, 'name' => 'Mato Grosso do Sul', 'uf' => 'MS'],
            ['id_country' => 1, 'name' => 'Minas Gerais', 'uf' => 'MG'],
            ['id_country' => 1, 'name' => 'Pará', 'uf' => 'PA'],
            ['id_country' => 1, 'name' => 'Paraíba', 'uf' => 'PB'],
            ['id_country' => 1, 'name' => 'Paraná', 'uf' => 'PR'],
            ['id_country' => 1, 'name' => 'Pernambuco', 'uf' => 'PE'],
            ['id_country' => 1, 'name' => 'Piauí', 'uf' => 'PI'],
            ['id_country' => 1, 'name' => 'Rio de Janeiro', 'uf' => 'RJ'],
            ['id_country' => 1, 'name' => 'Rio Grande do Norte', 'uf' => 'RN'],
            ['id_country' => 1, 'name' => 'Rio Grande do Sul', 'uf' => 'RS'],
            ['id_country' => 1, 'name' => 'Rondônia', 'uf' => 'RO'],
            ['id_country' => 1, 'name' => 'Roraima', 'uf' => 'RR'],
            ['id_country' => 1, 'name' => 'Santa Catarina', 'uf' => 'SC'],
            ['id_country' => 1, 'name' => 'São Paulo', 'uf' => 'SP'],
            ['id_country' => 1, 'name' => 'Sergipe', 'uf' => 'SE'],
            ['id_country' => 1, 'name' => 'Tocantins', 'uf' => 'TO']
        ]);
    }
}
