<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Cultivo;
use App\Models\Insumo;
use App\Models\Inventario;
use App\Models\Lote;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@sgiva.local',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        $admin = User::firstOrCreate([
            'email' => 'admin@sgiva.local',
        ], [
            'name' => 'Administrador',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user = User::firstOrCreate([
            'email' => 'usuario@sgiva.local',
        ], [
            'name' => 'Usuario General',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $cafe = Cultivo::firstOrCreate(['nombre' => 'Café'], ['estado' => true]);
        $aguacate = Cultivo::firstOrCreate(['nombre' => 'Aguacate'], ['estado' => true]);
        $cacao = Cultivo::firstOrCreate(['nombre' => 'Cacao'], ['estado' => true]);

        $loteA = Lote::firstOrCreate(['codigo' => 'A1'], ['cultivo_id' => $cafe->id, 'cantidad_filas' => 18, 'estado' => 'Disponible']);
        $loteB = Lote::firstOrCreate(['codigo' => 'B2'], ['cultivo_id' => $aguacate->id, 'cantidad_filas' => 22, 'estado' => 'Disponible']);
        $loteC = Lote::firstOrCreate(['codigo' => 'C3'], ['cultivo_id' => $cacao->id, 'cantidad_filas' => 16, 'estado' => 'Disponible']);

        Inventario::firstOrCreate([
            'lote_id' => $loteA->id,
            'fila' => 1,
        ], [
            'cantidad_actual' => 180,
            'cantidad_inicial' => 200,
        ]);

        Inventario::firstOrCreate([
            'lote_id' => $loteB->id,
            'fila' => 2,
        ], [
            'cantidad_actual' => 210,
            'cantidad_inicial' => 220,
        ]);

        Inventario::firstOrCreate([
            'lote_id' => $loteC->id,
            'fila' => 3,
        ], [
            'cantidad_actual' => 145,
            'cantidad_inicial' => 160,
        ]);

        Actividad::firstOrCreate([
            'user_id' => $admin->id,
            'tipo_actividad' => 'Riego',
            'lote_id' => $loteA->id,
            'fecha' => Carbon::now()->subDays(1)->format('Y-m-d'),
        ], [
            'observaciones' => 'Riego completo en Lote A1.',
        ]);

        Actividad::firstOrCreate([
            'user_id' => $user->id,
            'tipo_actividad' => 'Fumigación',
            'lote_id' => $loteB->id,
            'fecha' => Carbon::now()->subDays(2)->format('Y-m-d'),
        ], [
            'observaciones' => 'Aplicado producto orgánico.',
        ]);

        Insumo::firstOrCreate([
            'tipo' => 'Fertilizante',
            'fecha_ingreso' => Carbon::now()->subDays(5)->format('Y-m-d'),
        ], [
            'cantidad' => 50,
            'cultivo_id' => $cafe->id,
            'observaciones' => 'Detalle ecológico para sembrado de Café.',
        ]);

        Insumo::firstOrCreate([
            'tipo' => 'Bolsa',
            'fecha_ingreso' => Carbon::now()->subDays(3)->format('Y-m-d'),
        ], [
            'cantidad' => 120,
            'cultivo_id' => null,
            'observaciones' => 'Bolsas de empaque y protección.',
        ]);

        Venta::firstOrCreate([
            'cultivo_id' => $cafe->id,
            'lote_id' => $loteA->id,
            'cantidad_vendida' => 45,
            'fecha_venta' => Carbon::now()->subDays(2)->format('Y-m-d'),
        ], [
            'precio_unitario' => 15.75,
            'total' => 708.75,
        ]);

        Venta::firstOrCreate([
            'cultivo_id' => $aguacate->id,
            'lote_id' => $loteB->id,
            'cantidad_vendida' => 32,
            'fecha_venta' => Carbon::now()->subDays(7)->format('Y-m-d'),
        ], [
            'precio_unitario' => 20.00,
            'total' => 640.00,
        ]);
    }
}
