<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cultivos = Cultivo::where('estado', true)->orderBy('nombre')->get();
        $tipos = Insumo::select('tipo')->distinct()->orderBy('tipo')->pluck('tipo');

        $query = Insumo::with('cultivo');

        $query->when($request->filled('cultivo_id'), fn ($query, $cultivoId) => $query->where('cultivo_id', $cultivoId));
        $query->when($request->filled('tipo'), fn ($query, $tipo) => $query->where('tipo', $tipo));
        $query->when($request->filled('fecha_inicio'), fn ($query, $fecha) => $query->whereDate('fecha_ingreso', '>=', $fecha));
        $query->when($request->filled('fecha_fin'), fn ($query, $fecha) => $query->whereDate('fecha_ingreso', '<=', $fecha));
        $query->when($request->filled('search'), function ($query, $search) {
            $query->where('tipo', 'like', '%' . $search . '%')
                ->orWhere('observaciones', 'like', '%' . $search . '%')
                ->orWhereHas('cultivo', fn ($query) => $query->where('nombre', 'like', '%' . $search . '%'));
        });

        $sort = in_array($request->query('sort'), ['id', 'tipo', 'cantidad', 'fecha_ingreso'])
            ? $request->query('sort')
            : 'fecha_ingreso';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $insumos = $query->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        $totales = [
            'cantidad' => (clone $query)->sum('cantidad'),
        ];

        return view('insumos.index', compact('insumos', 'cultivos', 'tipos', 'totales'));
    }

    public function create()
    {
        $this->authorize('create', Insumo::class);
        $cultivos = Cultivo::where('estado', true)->get();
        return view('insumos.create', compact('cultivos'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Insumo::class);

        $validated = $request->validate([
            'tipo' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:1',
            'cultivo_id' => 'nullable|exists:cultivos,id',
            'fecha_ingreso' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        Insumo::create($validated);
        return redirect()->route('insumos.index')->with('success', 'Insumo registrado correctamente.');
    }

    public function show(Insumo $insumo)
    {
        $this->authorize('view', $insumo);
        $insumo->load('cultivo');
        return view('insumos.show', compact('insumo'));
    }

    public function edit(Insumo $insumo)
    {
        $this->authorize('update', $insumo);
        $cultivos = Cultivo::where('estado', true)->get();
        return view('insumos.edit', compact('insumo', 'cultivos'));
    }

    public function update(Request $request, Insumo $insumo)
    {
        $this->authorize('update', $insumo);

        $validated = $request->validate([
            'tipo' => 'required|string|max:100',
            'cantidad' => 'required|integer|min:1',
            'cultivo_id' => 'nullable|exists:cultivos,id',
            'fecha_ingreso' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $insumo->update($validated);
        return redirect()->route('insumos.index')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy(Insumo $insumo)
    {
        $this->authorize('delete', $insumo);
        
        $insumo->delete();
        return redirect()->route('insumos.index')->with('success', 'Insumo eliminado correctamente.');
    }
}
