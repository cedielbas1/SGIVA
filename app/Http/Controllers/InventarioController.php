<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Inventario;
use App\Models\Lote;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $lotes = Lote::with('cultivo')->get();
        $cultivos = Cultivo::orderBy('nombre')->get();

        $query = Inventario::with('lote.cultivo');

        $query->when($request->filled('lote_id'), fn ($query, $loteId) => $query->where('lote_id', $loteId));
        $query->when($request->filled('cultivo_id'), fn ($query, $cultivoId) => $query->whereHas('lote', fn ($query) => $query->where('cultivo_id', $cultivoId)));
        $query->when($request->filled('fecha_inicio'), fn ($query, $fecha) => $query->whereDate('created_at', '>=', $fecha));
        $query->when($request->filled('fecha_fin'), fn ($query, $fecha) => $query->whereDate('created_at', '<=', $fecha));
        $query->when($request->filled('search'), function ($query, $search) {
            $query->where('fila', 'like', '%' . $search . '%')
                ->orWhereHas('lote', fn ($query) => $query->where('codigo', 'like', '%' . $search . '%'))
                ->orWhereHas('lote.cultivo', fn ($query) => $query->where('nombre', 'like', '%' . $search . '%'));
        });

        $sort = in_array($request->query('sort'), ['id', 'fila', 'cantidad_inicial', 'cantidad_actual', 'created_at'])
            ? $request->query('sort')
            : 'created_at';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $inventarios = $query->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        $totales = [
            'cantidad_inicial' => (clone $query)->sum('cantidad_inicial'),
            'cantidad_actual' => (clone $query)->sum('cantidad_actual'),
        ];

        return view('inventarios.index', compact('inventarios', 'lotes', 'cultivos', 'totales'));
    }

    public function create()
    {
        $this->authorize('create', Inventario::class);
        $lotes = Lote::with('cultivo')->get();
        return view('inventarios.create', compact('lotes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Inventario::class);

        $validated = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fila' => 'required|integer|min:1',
            'cantidad_inicial' => 'required|integer|min:0',
            'cantidad_actual' => 'required|integer|min:0',
        ]);

        Inventario::create($validated);
        return redirect()->route('inventarios.index')->with('success', 'Inventario registrado correctamente.');
    }

    public function show(Inventario $inventario)
    {
        $this->authorize('view', $inventario);
        $inventario->load('lote.cultivo');
        return view('inventarios.show', compact('inventario'));
    }

    public function edit(Inventario $inventario)
    {
        $this->authorize('update', $inventario);
        $lotes = Lote::with('cultivo')->get();
        return view('inventarios.edit', compact('inventario', 'lotes'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $this->authorize('update', $inventario);

        $validated = $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fila' => 'required|integer|min:1',
            'cantidad_inicial' => 'required|integer|min:0',
            'cantidad_actual' => 'required|integer|min:0',
        ]);

        $inventario->update($validated);
        return redirect()->route('inventarios.index')->with('success', 'Inventario actualizado correctamente.');
    }

    public function destroy(Inventario $inventario)
    {
        $this->authorize('delete', $inventario);
        
        $inventario->delete();
        return redirect()->route('inventarios.index')->with('success', 'Inventario eliminado correctamente.');
    }
}
