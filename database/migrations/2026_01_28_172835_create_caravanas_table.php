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
        Schema::create('caravanas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_usuario_propietario')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('matricula', 20)->unique();
            $table->string('marca', 100);
            $table->string('modelo', 100);
            $table->integer('kilometraje')->default(0);
            $table->decimal('nota', 2, 1)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caravanas');
    }
};
