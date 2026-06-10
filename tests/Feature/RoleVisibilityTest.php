<?php

namespace Tests\Feature;

use App\Models\Actividad;
use App\Models\Cultivo;
use App\Models\Insumo;
use App\Models\Inventario;
use App\Models\Lote;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleVisibilityTest extends TestCase
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

    public function test_admin_sees_create_button_on_cultivos_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('cultivos.index'));

        $response->assertStatus(200);
        $response->assertSee('Nuevo Cultivo');
    }

    public function test_user_does_not_see_create_button_on_cultivos_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('cultivos.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Nuevo Cultivo');
    }

    public function test_admin_sees_create_button_on_lotes_index()
    {
        $response = $this->actingAs($this->admin)->get(route('lotes.index'));

        $response->assertStatus(200);
        $response->assertSee('Nuevo Lote');
    }

    public function test_user_does_not_see_create_button_on_lotes_index()
    {
        $response = $this->actingAs($this->user)->get(route('lotes.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Nuevo Lote');
    }

    public function test_admin_sees_create_button_on_inventarios_index()
    {
        $response = $this->actingAs($this->admin)->get(route('inventarios.index'));

        $response->assertStatus(200);
        $response->assertSee('Nuevo Inventario');
    }

    public function test_user_does_not_see_create_button_on_inventarios_index()
    {
        $response = $this->actingAs($this->user)->get(route('inventarios.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Nuevo Inventario');
    }

    public function test_admin_sees_create_button_on_insumos_index()
    {
        $response = $this->actingAs($this->admin)->get(route('insumos.index'));

        $response->assertStatus(200);
        $response->assertSee('Nuevo Insumo');
    }

    public function test_user_does_not_see_create_button_on_insumos_index()
    {
        $response = $this->actingAs($this->user)->get(route('insumos.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Nuevo Insumo');
    }

    public function test_admin_sees_create_button_on_actividades_index()
    {
        $response = $this->actingAs($this->admin)->get(route('actividades.index'));

        $response->assertStatus(200);
        $response->assertSee('Nueva Actividad');
    }

    public function test_user_sees_create_button_on_actividades_index()
    {
        $response = $this->actingAs($this->user)->get(route('actividades.index'));

        $response->assertStatus(200);
        $response->assertSee('Nueva Actividad');
    }

    public function test_admin_sees_create_button_on_ventas_index()
    {
        $response = $this->actingAs($this->admin)->get(route('ventas.index'));

        $response->assertStatus(200);
        $response->assertSee('Nueva Venta');
    }

    public function test_user_does_not_see_create_button_on_ventas_index()
    {
        $response = $this->actingAs($this->user)->get(route('ventas.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Nueva Venta');
    }

    public function test_super_admin_sees_edit_and_delete_buttons_for_lote()
    {
        $this->createLote();

        $response = $this->actingAs($this->superAdmin)->get(route('lotes.index'));

        $response->assertStatus(200);
        $response->assertSee('Editar');
        $response->assertSee('Eliminar');
    }

    public function test_regular_user_does_not_see_edit_or_delete_buttons_for_lote()
    {
        $this->createLote();

        $response = $this->actingAs($this->user)->get(route('lotes.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
        $response->assertDontSee('Eliminar');
    }

    public function test_super_admin_sees_edit_and_delete_buttons_for_insumo()
    {
        $this->createInsumo();

        $response = $this->actingAs($this->superAdmin)->get(route('insumos.index'));

        $response->assertStatus(200);
        $response->assertSee('Editar');
        $response->assertSee('Eliminar');
    }

    public function test_regular_user_does_not_see_edit_or_delete_buttons_for_insumo()
    {
        $this->createInsumo();

        $response = $this->actingAs($this->user)->get(route('insumos.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
        $response->assertDontSee('Eliminar');
    }

    public function test_super_admin_sees_edit_and_delete_buttons_for_actividad()
    {
        $this->createActividad();

        $response = $this->actingAs($this->superAdmin)->get(route('actividades.index'));

        $response->assertStatus(200);
        $response->assertSee('Editar');
        $response->assertSee('Eliminar');
    }

    public function test_regular_user_does_not_see_edit_or_delete_buttons_for_actividad()
    {
        $this->createActividad();

        $response = $this->actingAs($this->user)->get(route('actividades.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
        $response->assertDontSee('Eliminar');
    }

    public function test_super_admin_sees_edit_and_delete_buttons_for_venta()
    {
        $this->createVenta();

        $response = $this->actingAs($this->superAdmin)->get(route('ventas.index'));

        $response->assertStatus(200);
        $response->assertSee('Editar');
        $response->assertSee('Eliminar');
    }

    public function test_regular_user_does_not_see_edit_or_delete_buttons_for_venta()
    {
        $this->createVenta();

        $response = $this->actingAs($this->user)->get(route('ventas.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
        $response->assertDontSee('Eliminar');
    }

    public function test_admin_sees_edit_button_on_cultivo_show()
    {
        $cultivo = $this->createCultivo();

        $response = $this->actingAs($this->admin)->get(route('cultivos.show', $cultivo));

        $response->assertStatus(200);
        $response->assertSee('Editar');
    }

    public function test_regular_user_does_not_see_edit_button_on_cultivo_show()
    {
        $cultivo = $this->createCultivo();

        $response = $this->actingAs($this->user)->get(route('cultivos.show', $cultivo));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
    }

    public function test_super_admin_sees_edit_button_on_lote_show()
    {
        $lote = $this->createLote();

        $response = $this->actingAs($this->superAdmin)->get(route('lotes.show', $lote));

        $response->assertStatus(200);
        $response->assertSee('Editar');
    }

    public function test_regular_user_does_not_see_edit_button_on_lote_show()
    {
        $lote = $this->createLote();

        $response = $this->actingAs($this->user)->get(route('lotes.show', $lote));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
    }

    public function test_admin_sees_edit_button_on_actividad_show()
    {
        $actividad = $this->createActividad();

        $response = $this->actingAs($this->admin)->get(route('actividades.show', $actividad));

        $response->assertStatus(200);
        $response->assertSee('Editar');
    }

    public function test_regular_user_does_not_see_edit_button_on_actividad_show()
    {
        $actividad = $this->createActividad();

        $response = $this->actingAs($this->user)->get(route('actividades.show', $actividad));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
    }

    public function test_super_admin_sees_edit_button_on_insumo_show()
    {
        $insumo = $this->createInsumo();

        $response = $this->actingAs($this->superAdmin)->get(route('insumos.show', $insumo));

        $response->assertStatus(200);
        $response->assertSee('Editar');
    }

    public function test_regular_user_does_not_see_edit_button_on_insumo_show()
    {
        $insumo = $this->createInsumo();

        $response = $this->actingAs($this->user)->get(route('insumos.show', $insumo));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
    }

    public function test_super_admin_sees_edit_button_on_venta_show()
    {
        $venta = $this->createVenta();

        $response = $this->actingAs($this->superAdmin)->get(route('ventas.show', $venta));

        $response->assertStatus(200);
        $response->assertSee('Editar');
    }

    public function test_regular_user_does_not_see_edit_button_on_venta_show()
    {
        $venta = $this->createVenta();

        $response = $this->actingAs($this->user)->get(route('ventas.show', $venta));

        $response->assertStatus(200);
        $response->assertDontSee('Editar');
    }

    protected function createCultivo(): Cultivo
    {
        return Cultivo::create(['nombre' => 'Cacao', 'estado' => true]);
    }

    protected function createLote(): Lote
    {
        $cultivo = $this->createCultivo();

        return Lote::create([
            'codigo' => 'LOT-001',
            'cultivo_id' => $cultivo->id,
            'cantidad_filas' => 10,
            'estado' => 'activo',
        ]);
    }

    protected function createInventario(): Inventario
    {
        $lote = $this->createLote();

        return Inventario::create([
            'lote_id' => $lote->id,
            'fila' => 1,
            'cantidad_actual' => 5,
            'cantidad_inicial' => 10,
        ]);
    }

    protected function createInsumo(): Insumo
    {
        $cultivo = $this->createCultivo();

        return Insumo::create([
            'tipo' => 'Fertilizante',
            'cantidad' => 20,
            'cultivo_id' => $cultivo->id,
            'fecha_ingreso' => '2026-01-01',
            'observaciones' => 'Aplicado por prueba',
        ]);
    }

    protected function createActividad(): Actividad
    {
        $lote = $this->createLote();

        return Actividad::create([
            'user_id' => $this->admin->id,
            'tipo_actividad' => 'Riego',
            'lote_id' => $lote->id,
            'fecha' => '2026-01-01',
            'observaciones' => 'Actividad de prueba',
        ]);
    }

    protected function createVenta(): Venta
    {
        $cultivo = $this->createCultivo();
        $lote = $this->createLote();

        return Venta::create([
            'cultivo_id' => $cultivo->id,
            'lote_id' => $lote->id,
            'cantidad_vendida' => 5,
            'precio_unitario' => 10.0,
            'total' => 50.0,
            'fecha_venta' => '2026-01-01',
        ]);
    }
}
