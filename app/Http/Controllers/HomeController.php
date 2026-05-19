<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Cultivo;
use App\Models\Insumo;
use App\Models\Inventario;
use App\Models\Lote;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = now();

        return view('dashboard', [
            'cultivosCount' => Cultivo::count(),
            'lotesCount' => Lote::count(),
            'inventariosCount' => Inventario::count(),
            'actividadesCount' => Actividad::count(),
            'insumosCount' => Insumo::count(),
            'ventasCount' => Venta::count(),
            'ventasTotal' => Venta::sum('total'),
            'ventasMesTotal' => Venta::whereMonth('fecha_venta', $today->month)
                ->whereYear('fecha_venta', $today->year)
                ->sum('total'),
            'cultivosPorLote' => Cultivo::withCount('lotes')
                ->orderByDesc('lotes_count')
                ->get(),
            'ventasUltimos7Dias' => Venta::select(DB::raw('fecha_venta as fecha'), DB::raw('sum(total) as total'))
                ->where('fecha_venta', '>=', $today->copy()->subDays(6))
                ->groupBy('fecha_venta')
                ->orderBy('fecha_venta')
                ->get(),
            'recentActivities' => Actividad::with(['usuario', 'lote.cultivo'])
                ->orderByDesc('fecha')
                ->take(5)
                ->get(),
        ]);
    }
}
