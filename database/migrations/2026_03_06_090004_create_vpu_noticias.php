<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpuNoticias extends Migration
{
    public function up(): void
    {
        Schema::create('vpu_noticias', function (Blueprint $table) {
            $table->increments('id_noticia');
            $table->string('nome');
            $table->text('descricao');
            $table->text('abreviacao')->nullable();
            $table->string('direitos')->nullable();
            $table->string('imagem')->nullable();
            $table->string('autor')->nullable();
            $table->boolean('delete')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vpu_noticias');
    }
}
