<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SeederConfigurationMail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table vpr_configuration_mail is empty
        if(DB::table('vpr_configuration_mail')->count() == 0){
            DB::table('vpr_configuration_mail')->insert([
                [
                    'id_configuration' => 1,
                    'smtp' => 'vk2.mtp.vk2.dataware.com.br',
                    'ssl' => 0,
                    'mail_send' => 'suporte@vk2.com.br',
                    'password_mail_send' => 'x88bx8m6',
                    'smtp_port' => '587'
                ]
            ]);
        }
    }
}