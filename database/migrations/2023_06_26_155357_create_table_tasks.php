<?php

use App\Enum\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',45);
            $table->string('descricao',200)->nullable();
            $table->mediumText('conteudo')->nullable();
            $table->boolean('feito')->default(Status::NaoFeito);
            $table->boolean('status')->default(Status::Ativo);
            $table->timestamp('prazo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
