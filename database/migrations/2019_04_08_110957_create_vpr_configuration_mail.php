<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprConfigurationMail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_configuration_mail
        Schema::create('vpr_configuration_mail', function (Blueprint $table) {
            $table->increments('id_configuration');
            $table->string('smtp', 250);
            $table->boolean('ssl')->default(false);
            $table->string('mail_send', 250);
            $table->string('password_mail_send', 250);
            $table->string('smtp_port', 250);
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
        Schema::dropIfExists('vpr_configuration_mail');
    }
}
