<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpuBanner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpu_banner', function (Blueprint $table) {
            $table->increments('id_banner');
            $table->string('name', 250);
            $table->string('link', 250);
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->boolean('delete')->default(0);  
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('vpu_banner');
    }
}
