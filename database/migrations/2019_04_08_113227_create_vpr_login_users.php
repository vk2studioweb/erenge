<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprLoginUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_login_users
        Schema::create('vpr_login_users', function (Blueprint $table) {
            $table->increments('id_login_user');
            $table->integer('id_class')->unsigned();
            $table->foreign('id_class')->references('id_login_class')->on('vpr_login_classes');
            $table->integer('id_permission')->unsigned();
            $table->foreign('id_permission')->references('id_login_permission')->on('vpr_login_permissions');
            
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('remember_token', 255)->nullable()->default(null);

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
        Schema::dropIfExists('vpr_login_users');
    }
}
