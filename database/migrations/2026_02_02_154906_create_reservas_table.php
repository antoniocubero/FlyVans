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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_usuario_reserva')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('id_anuncio')
                ->constrained('anuncios')
                ->onDelete('cascade');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada'])
                ->default('pendiente');

            $table->decimal('coste', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
