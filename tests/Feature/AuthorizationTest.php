<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cultivo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.local',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
        ]);

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.local',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->user = User::create([
            'name' => 'Usuario',
            'email' => 'user@test.local',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }

    public function test_user_cannot_create_cultivo()
    {
        $response = $this->actingAs($this->user)
            ->post('/cultivos', [
                'nombre' => 'Café',
                'estado' => true,
            ]);

        $response->assertStatus(403); // Forbidden
    }

    public function test_admin_can_create_cultivo()
    {
        $response = $this->actingAs($this->admin)
            ->post('/cultivos', [
                'nombre' => 'Café',
                'estado' => true,
            ]);

        $response->assertRedirect('/cultivos');
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Café']);
    }

    public function test_super_admin_can_create_cultivo()
    {
        $response = $this->actingAs($this->superAdmin)
            ->post('/cultivos', [
                'nombre' => 'Aguacate',
                'estado' => true,
            ]);

        $response->assertRedirect('/cultivos');
        $this->assertDatabaseHas('cultivos', ['nombre' => 'Aguacate']);
    }

    public function test_user_can_view_cultivos()
    {
        Cultivo::create(['nombre' => 'Cacao', 'estado' => true]);

        $response = $this->actingAs($this->user)
            ->get('/cultivos');

        $response->assertStatus(200);
        $response->assertSee('Cacao');
    }

    public function test_unauthenticated_cannot_access_cultivos()
    {
        $response = $this->get('/cultivos');

        $response->assertRedirect('/login');
    }

    public function test_new_user_has_user_role()
    {
        $user = User::create([
            'name' => 'New User',
            'email' => 'newuser@test.local',
            'password' => bcrypt('password'),
        ]);

        $this->assertEquals('user', $user->role);
    }

    public function test_validated_data_only_accepted()
    {
        $response = $this->actingAs($this->admin)
            ->post('/cultivos', [
                'nombre' => 'Tomate',
                'estado' => true,
                'malicious_field' => 'should_not_be_saved',
            ]);

        $this->assertDatabaseHas('cultivos', ['nombre' => 'Tomate']);
        $this->assertDatabaseMissing('cultivos', ['malicious_field' => 'should_not_be_saved']);
    }
}
