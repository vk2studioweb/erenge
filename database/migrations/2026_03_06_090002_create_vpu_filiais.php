<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpuFiliais extends Migration
{
    public function up(): void
    {
        Schema::create('vpu_filiais', function (Blueprint $table) {
            $table->increments('id_filial');
            $table->string('nome');
            $table->string('endereco');
            $table->string('coordenada')->nullable();
            $table->string('cep')->nullable();
            $table->integer('orden')->default(1);
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->text('descricao')->nullable();
            $table->boolean('delete')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vpu_filiais');
    }
}
