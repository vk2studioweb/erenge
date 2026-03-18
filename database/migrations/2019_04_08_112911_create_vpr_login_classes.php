<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVprLoginClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Core table vpr_login_classes
        Schema::create('vpr_login_classes', function (Blueprint $table) {
            $table->increments('id_login_class');
            $table->string('name', 255);
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
        Schema::dropIfExists('vpr_login_classes');
    }
}
