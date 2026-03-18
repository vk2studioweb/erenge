<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprNavGroupMenuUpload extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpr_nav_group_menu_upload', function (Blueprint $table) {
            $table->increments('id_upload');
            $table->integer('id_menu')->unsigned();
            $table->foreign('id_menu')->references('id_nav_group_menu')->on('vpr_nav_group_menu');

            $table->integer('id_register');
            $table->string('hash_temp', 255);
            $table->string('extension', 255);
            $table->string('name', 255);
            $table->text('description');
            $table->string('author', 255);
            $table->string('image_rights', 255);
			$table->integer('id_type');

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
        Schema::dropIfExists('vpr_nav_group_menu_upload');
    }
    
}
