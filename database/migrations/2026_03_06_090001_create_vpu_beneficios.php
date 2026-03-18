<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpuBeneficios extends Migration
{
    public function up(): void
    {
        Schema::create('vpu_beneficios', function (Blueprint $table) {
            $table->increments('id_beneficio');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->integer('orden')->default(1);
            $table->boolean('delete')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vpu_beneficios');
    }
}
