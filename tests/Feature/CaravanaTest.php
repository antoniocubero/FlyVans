<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Caravana;

class CaravanaTest extends TestCase
{
    use RefreshDatabase;


    public function test_usuario_puede_crear_caravana()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('vans.store'), [
            'marca' => 'Fiat',
            'modelo' => 'Ducato Camper',
            'kilometros' => 10000,
            'matricula' => '1234BCD',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('caravanas', [
            'marca' => 'Fiat',
            'modelo' => 'Ducato Camper',
            'id_usuario_propietario' => $user->id,
        ]);
    }


    public function test_matricula_invalida_falla_validacion()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('vans.store'), [
            'marca' => 'Fiat',
            'modelo' => 'Ducato Camper',
            'kilometros' => 10000,
            'matricula' => 'AAAA111', // inválida
        ]);

        $response->assertSessionHasErrors('matricula');
    }

    public function test_usuario_no_puede_editar_caravana_de_otro()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $caravana = Caravana::factory()->create([
            'id_usuario_propietario' => $owner->id,
        ]);

        $this->actingAs($otherUser);

        $response = $this->put(route('vans.update', $caravana), [
            'marca' => 'Ford',
            'modelo' => 'Transit',
            'kilometros' => 20000,
            'matricula' => '1234BCD',
        ]);

        $response->assertStatus(404);
    }

    public function test_usuario_no_puede_borrar_caravana_de_otro()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $caravana = Caravana::factory()->create([
            'id_usuario_propietario' => $owner->id,
        ]);

        $this->actingAs($otherUser);

        $response = $this->delete(route('vans.destroy', $caravana));

        $response->assertStatus(404);

        $this->assertDatabaseHas('caravanas', [
            'id' => $caravana->id,
        ]);
    }

    public function test_propietario_puede_editar_caravana()
    {
        $user = User::factory()->create();

        $caravana = Caravana::factory()->create([
            'id_usuario_propietario' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('vans.update', $caravana), [
            'marca' => 'Volkswagen',
            'modelo' => 'California',
            'kilometros' => 5000,
            'matricula' => '1234BCD',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('caravanas', [
            'id' => $caravana->id,
            'marca' => 'Volkswagen',
        ]);
    }

    public function test_kilometros_no_pueden_ser_negativos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('vans.store'), [
            'marca' => 'Fiat',
            'modelo' => 'Ducato',
            'kilometros' => -10,
            'matricula' => '1234BCD',
        ]);

        $response->assertSessionHasErrors('kilometros');
    }
}
