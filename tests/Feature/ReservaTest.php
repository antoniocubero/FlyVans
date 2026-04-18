<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Anuncio;
use PHPUnit\Framework\Attributes\Test;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_reserva()
    {
        $reserva = Reserva::factory()->forTest()->create();

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'pendiente'
        ]);
    }

    public function test_aceptar_reserva_pendiente()
    {
        $reserva = Reserva::factory()->forTest()->create([
            'estado' => 'pendiente',
        ]);

        $reserva->aceptar();

        $this->assertEquals('confirmada', $reserva->fresh()->estado);
    }

    public function test_cancelar_reserva()
    {
        $reserva = Reserva::factory()->forTest()->create();

        $reserva->update([
            'estado' => 'cancelada'
        ]);

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'estado' => 'cancelada'
        ]);
    }

    public function test_fecha_fin_no_puede_ser_menor_que_inicio()
    {
        $reserva = Reserva::factory()->forTest()->make([
            'fecha_inicio' => now(),
            'fecha_fin' => now()->subDay()
        ]);

        $this->assertTrue($reserva->fecha_fin < $reserva->fecha_inicio);
    }

    public function test_no_se_puede_cancelar_una_reserva_confirmada()
    {
        $reserva = Reserva::factory()->forTest()->create([
            'estado' => 'confirmada',
        ]);

        $reserva->cancelar();

        $this->assertEquals('confirmada', $reserva->fresh()->estado);
    }

    public function test_calculo_coste_reserva()
    {
        $anuncio = Anuncio::factory()->forTest()->create([
            'precio_dia' => 50
        ]);

        $inicio = now();
        $fin = now()->addDays(2);

        $coste = round(Reserva::calcularCoste($anuncio, $inicio, $fin));

        $this->assertEquals(150, $coste);
    }

}
