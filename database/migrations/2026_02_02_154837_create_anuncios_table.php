<?php

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
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_caravana')
                ->constrained('caravanas')
                ->onDelete('cascade');

            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->decimal('precio_dia', 8, 2);

            $table->enum('estado', ['activo', 'inactivo', 'reservado'])->default('activo');
            $table->string('localizacion', 150);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};
