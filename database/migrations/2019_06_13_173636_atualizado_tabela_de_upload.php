<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AtualizadoTabelaDeUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adicionado colunas de order e modificado coluna de hash para aceitar valores null
        Schema::table('vpr_nav_group_menu_upload', function (Blueprint $table) {
            $table->string('order', 250);
            $table->dropColumn('hash_temp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove modificações
        Schema::table('vpr_nav_group_menu_upload', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->string('hash_temp', 255);
        });
    }
}
