<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Valoracion;
use App\Models\Caravana;
use App\Models\Anuncio;




class ValoracionTest extends TestCase
{

    use RefreshDatabase;

public function test_solo_el_usuario_de_la_reserva_puede_acceder_a_valoracion()
{
    $reserva = Reserva::factory()->forTest()->create();

    $otroUsuario = User::factory()->create();

    $this->actingAs($otroUsuario);

    $response = $this->get(route('rating.create', $reserva));

    $response->assertStatus(404);
}

public function test_no_se_puede_valorar_si_la_reserva_no_ha_terminado()
{
    $user = User::factory()->create();

    $reserva = Reserva::factory()->forTest()->create([
        'id_usuario_reserva' => $user->id,
        'estado' => 'confirmada',
        'fecha_fin' => now()->addDays(5),
    ]);

    $this->actingAs($user);

    $response = $this->post(route('rating.store', $reserva), [
        'puntuacion' => 5,
    ]);

    $response->assertSessionHas('error');
}

public function test_no_se_puede_valorar_dos_veces()
{
    $user = User::factory()->create();

    $reserva = Reserva::factory()->forTest()->create([
        'id_usuario_reserva' => $user->id,
        'estado' => 'confirmada',
        'fecha_fin' => now()->subDays(1),
    ]);

    Valoracion::factory()->create([
        'id_reserva' => $reserva->id,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('rating.store', $reserva), [
        'puntuacion' => 4,
    ]);

    $response->assertSessionHas('error');
}

public function test_puntuacion_fuera_de_rango_falla()
{
    $user = User::factory()->create();

    $reserva = Reserva::factory()->forTest()->create([
        'id_usuario_reserva' => $user->id,
        'estado' => 'confirmada',
        'fecha_fin' => now()->subDay(),
    ]);

    $this->actingAs($user);

    $response = $this->post(route('rating.store', $reserva), [
        'puntuacion' => 10,
    ]);

    $response->assertSessionHasErrors('puntuacion');
}

public function test_crear_valoracion_correctamente()
{
    $user = User::factory()->create();

    $reserva = Reserva::factory()->forTest()->create([
        'id_usuario_reserva' => $user->id,
        'estado' => 'confirmada',
        'fecha_fin' => now()->subDay(),
    ]);

    $this->actingAs($user);

    $this->post(route('rating.store', $reserva), [
        'puntuacion' => 5,
        'comentario' => 'Todo perfecto',
    ]);

    $this->assertDatabaseHas('valoraciones', [
        'id_reserva' => $reserva->id,
        'puntuacion' => 5,
    ]);
}

public function test_la_media_de_la_caravana_se_actualiza()
{
    $user = User::factory()->create();

    $caravana = Caravana::factory()->create([
        'id_usuario_propietario' => $user->id,
    ]);

    $anuncio = Anuncio::factory()->create([
        'id_caravana' => $caravana->id,
    ]);

    $reserva = Reserva::factory()->forTest()->create([
        'id_usuario_reserva' => $user->id,
        'id_anuncio' => $anuncio->id,
        'estado' => 'confirmada',
        'fecha_fin' => now()->subDay(),
    ]);

    $this->actingAs($user);

    $this->post(route('rating.store', $reserva), [
        'puntuacion' => 4,
    ]);

    $caravana->refresh();

    $this->assertEquals(4, $caravana->nota);
}
}
