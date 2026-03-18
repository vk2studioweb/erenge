<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_permission
        Schema::create('vpr_permission', function (Blueprint $table) {
            $table->increments('id_permission');
            $table->integer('id_menu')->unsigned();
            $table->foreign('id_menu')->references('id_nav_group_menu')->on('vpr_nav_group_menu');
            $table->integer('id_group')->unsigned();
            $table->foreign('id_group')->references('id_nav_group')->on('vpr_nav_group');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id_login_user')->on('vpr_login_users');

            $table->boolean('view')->default(true);
            $table->boolean('edit')->default(true);
            $table->boolean('add')->default(true);
            $table->boolean('upload')->default(true);
            $table->boolean('delete')->default(true);

            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('vpr_permission');
    }
}
