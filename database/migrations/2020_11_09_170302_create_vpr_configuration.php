<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_configuration
        Schema::create('vpr_configuration', function (Blueprint $table) {
            $table->increments('id_configuration');
            $table->string('name', 250);
            $table->string('keywords', 250);
            $table->string('analytics', 250);
            $table->string('mail', 250);
            $table->boolean('site_on')->default(true);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('vpr_configuration');
    }
}