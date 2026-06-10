<?php

namespace Tests\Feature;

use App\Models\Actividad;
use App\Models\Cultivo;
use App\Models\Lote;
use App\Models\User;
use App\Models\Venta;
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

    public function test_user_can_create_actividad()
    {
        $cultivo = Cultivo::create(['nombre' => 'Cacao', 'estado' => true]);
        $lote = Lote::create([
            'codigo' => 'LOT-002',
            'cultivo_id' => $cultivo->id,
            'cantidad_filas' => 5,
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($this->user)
            ->post('/actividades', [
                'tipo_actividad' => 'Riego',
                'lote_id' => $lote->id,
                'fecha' => '2026-01-01',
                'observaciones' => 'Test de actividad',
            ]);

        $response->assertRedirect('/actividades');
        $this->assertDatabaseHas('actividades', [
            'tipo_actividad' => 'Riego',
            'lote_id' => $lote->id,
        ]);
    }

    public function test_admin_can_create_venta()
    {
        $cultivo = Cultivo::create(['nombre' => 'Cacao', 'estado' => true]);
        $lote = Lote::create([
            'codigo' => 'LOT-003',
            'cultivo_id' => $cultivo->id,
            'cantidad_filas' => 10,
            'estado' => 'activo',
        ]);

        $response = $this->actingAs($this->admin)
            ->post('/ventas', [
                'cultivo_id' => $cultivo->id,
                'lote_id' => $lote->id,
                'cantidad_vendida' => 2,
                'precio_unitario' => 50.0,
                'fecha_venta' => '2026-01-01',
            ]);

        $response->assertRedirect('/ventas');
        $this->assertDatabaseHas('ventas', ['cantidad_vendida' => 2, 'total' => 100.0]);
    }

    public function test_admin_can_update_venta()
    {
        $cultivo = Cultivo::create(['nombre' => 'Cacao', 'estado' => true]);
        $lote = Lote::create([
            'codigo' => 'LOT-004',
            'cultivo_id' => $cultivo->id,
            'cantidad_filas' => 10,
            'estado' => 'activo',
        ]);

        $venta = Venta::create([
            'cultivo_id' => $cultivo->id,
            'lote_id' => $lote->id,
            'cantidad_vendida' => 2,
            'precio_unitario' => 50.0,
            'total' => 100.0,
            'fecha_venta' => '2026-01-01',
        ]);

        $response = $this->actingAs($this->admin)
            ->put('/ventas/' . $venta->id, [
                'cultivo_id' => $cultivo->id,
                'lote_id' => $lote->id,
                'cantidad_vendida' => 3,
                'precio_unitario' => 50.0,
                'fecha_venta' => '2026-01-02',
            ]);

        $response->assertRedirect('/ventas');
        $this->assertDatabaseHas('ventas', ['id' => $venta->id, 'cantidad_vendida' => 3, 'total' => 150.0]);
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
