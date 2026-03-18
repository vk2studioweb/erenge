<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVprNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpr_notifications', function (Blueprint $table) {
            $table->increments('id_notification');
            $table->string('title')->nullable();
            $table->string('message');
            $table->string('icon')->nullable();
            $table->string('type')->nullable();
            
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id_login_user')->on('vpr_login_users');

            $table->boolean('read')->default(false);

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
        Schema::dropIfExists('vpr_notifications');
    }
}
