<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprNavGroupMenuStyleCollumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_nav_group_menu_style_collumns
        Schema::create('vpr_nav_group_menu_style_collumns', function (Blueprint $table) {
            $table->increments('id_menu_style_list');
            $table->integer('id_menu_style')->unsigned();
            $table->foreign('id_menu_style')->references('id_menu_style')->on('vpr_nav_group_menu_style');

            $table->string('name', 255);
            $table->string('collumn', 255);
            $table->boolean('default')->default(false);
            $table->string('order', 255);
            $table->boolean('function')->default(false);
            $table->integer('legenth')->nullable()->default(null);
            $table->integer('size');

            $table->boolean('delete')->default(false);
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
        Schema::dropIfExists('vpr_nav_group_menu_style_collumns');
    }
}
