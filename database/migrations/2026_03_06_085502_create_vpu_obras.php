<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpuObras extends Migration
{
    public function up(): void
    {
        Schema::create('vpu_obras', function (Blueprint $table) {
            $table->increments('id_obra');

            $table->integer('servico_id')->unsigned();
            $table->foreign('servico_id')->references('id_servico')->on('vpu_servicos');

            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('local_obra');
            $table->string('coordenada')->nullable();
            $table->longText('detalhes')->nullable();
            $table->integer('order')->default(1);
            $table->boolean('delete')->default(0);  
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->useCurrent(); 
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vpu_obras');
    }
};
