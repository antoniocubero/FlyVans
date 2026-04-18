<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class UserTest extends TestCase
{
    use RefreshDatabase;

public function test_usuario_puede_actualizar_su_perfil()
{
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->patch(route('profile.update'), [
        'name' => 'Nuevo Nombre',
        'email' => 'nuevo@email.com',
    ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Nuevo Nombre',
        'email' => 'nuevo@email.com',
    ]);
}

public function test_email_duplicado_falla_validacion()
{
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $this->actingAs($user1);

    $response = $this->patch(route('profile.update'), [
        'name' => 'test',
        'email' => $user2->email,
    ]);

    $response->assertSessionHasErrors('email');
}
}
