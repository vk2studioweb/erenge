<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprLoginUsersResets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_login_users_resets
        Schema::create('vpr_login_users_resets', function (Blueprint $table) {
            $table->increments('id_login_user_reset');

            $table->integer('id_class')->unsigned();
            $table->foreign('id_class')->references('id_login_class')->on('vpr_login_classes');
            
            $table->string('token', 250);
            $table->string('email', 250);

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
        // Drop table
        Schema::dropIfExists('vpr_login_users_resets');
    }
}
