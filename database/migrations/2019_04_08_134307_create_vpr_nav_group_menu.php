<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprNavGroupMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_nav_group_menu
        Schema::create('vpr_nav_group_menu', function (Blueprint $table) {
            $table->increments('id_nav_group_menu');
            $table->integer('id_group')->unsigned();
            $table->foreign('id_group')->references('id_nav_group')->on('vpr_nav_group');

            $table->string('name', 255);
            $table->string('link', 255);
            $table->boolean('visible')->default(1);

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
        Schema::dropIfExists('vpr_nav_group_menu');
    }
}
