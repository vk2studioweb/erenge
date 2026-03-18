<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpuAddress extends Migration
{
    public function up(): void
    {
        Schema::create('vpu_address', function (Blueprint $table) {
            $table->increments('id_address');
            $table->string('address');
            $table->string('celphone')->nullable();
            $table->string('mail')->nullable();
            $table->string('coords')->nullable()->comment('Formato: lat,lng (ex: -27.5954,48.5480)');
            $table->boolean('delete')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vpu_address');
    }
}
