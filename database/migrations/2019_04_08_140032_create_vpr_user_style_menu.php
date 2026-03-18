<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprUserStyleMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_user_style_menu
        Schema::create('vpr_user_style_menu', function (Blueprint $table) {
            $table->increments('id_menu_style_list');
            $table->integer('id_menu')->unsigned();
            $table->foreign('id_menu')->references('id_nav_group_menu')->on('vpr_nav_group_menu');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id_login_user')->on('vpr_login_users');
            $table->integer('id_style')->unsigned();

            $table->timestamp('created_at')->useCurrent(); 
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table
        Schema::dropIfExists('vpr_user_style_menu');
    }
}
