<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Caravana;
use App\Models\Anuncio;


class AnuncioTest extends TestCase
{
    use RefreshDatabase;

public function test_usuario_puede_crear_anuncio()
{
    $user = User::factory()->create();
    $caravana = Caravana::factory()->create([
        'id_usuario_propietario' => $user->id
    ]);

    $this->actingAs($user);

    $response = $this->post(route('ads.store'), [
        'titulo' => 'Mi anuncio',
        'descripcion' => 'Descripcion test',
        'precio_dia' => 50,
        'localizacion' => 'sevilla',
        'id_caravana' => $caravana->id,
    ]);

    $response->assertRedirect(route('profile'));

    $this->assertDatabaseHas('anuncios', [
        'titulo' => 'mi anuncio',
        'id_caravana' => $caravana->id,
    ]);
}

public function test_no_puede_usar_caravana_de_otro_usuario()
{
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $caravana = Caravana::factory()->create([
        'id_usuario_propietario' => $owner->id
    ]);

    $this->actingAs($otherUser);

    $response = $this->post(route('ads.store'), [
        'titulo' => 'test',
        'descripcion' => 'test',
        'precio_dia' => 50,
        'localizacion' => 'sevilla',
        'id_caravana' => $caravana->id,
    ]);

    $response->assertSessionHasErrors('id_caravana');
}

public function test_propietario_puede_actualizar_anuncio()
{
    $user = User::factory()->create();

    $caravana = Caravana::factory()->create([
        'id_usuario_propietario' => $user->id
    ]);

    $anuncio = Anuncio::factory()->create([
        'id_caravana' => $caravana->id
    ]);

    $this->actingAs($user);

    $response = $this->put(route('ads.update', $anuncio), [
        'titulo' => 'nuevo titulo',
        'descripcion' => 'desc',
        'precio_dia' => 60,
        'localizacion' => 'madrid',
        'id_caravana' => $caravana->id,
    ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('anuncios', [
        'id' => $anuncio->id,
        'titulo' => 'nuevo titulo',
    ]);
}

public function test_no_puede_editar_anuncio_de_otro_usuario()
{
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $caravana = Caravana::factory()->create([
        'id_usuario_propietario' => $owner->id
    ]);

    $anuncio = Anuncio::factory()->create([
        'id_caravana' => $caravana->id
    ]);

    $this->actingAs($otherUser);

    $response = $this->put(route('ads.update', $anuncio), [
        'titulo' => 'hack',
        'descripcion' => 'hack',
        'precio_dia' => 10,
        'localizacion' => 'x',
        'id_caravana' => $caravana->id,
    ]);

    $response->assertStatus(404);
}

public function test_no_puede_borrar_anuncio_de_otro_usuario()
{
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $caravana = Caravana::factory()->create([
        'id_usuario_propietario' => $owner->id
    ]);

    $anuncio = Anuncio::factory()->create([
        'id_caravana' => $caravana->id
    ]);

    $this->actingAs($otherUser);

    $response = $this->delete(route('ads.destroy', $anuncio));

    $response->assertStatus(404);
}
}
