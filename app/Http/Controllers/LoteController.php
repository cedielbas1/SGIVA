<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    /**
     * Constructor - aplicar middleware de autenticación
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cultivos = Cultivo::orderBy('nombre')->get();
        $estados = Lote::select('estado')->distinct()->orderBy('estado')->pluck('estado');

        $query = Lote::with('cultivo');

        $query->when($request->filled('estado'), fn ($query, $estado) => $query->where('estado', $estado));
        $query->when($request->filled('cultivo_id'), fn ($query, $cultivoId) => $query->where('cultivo_id', $cultivoId));
        $query->when($request->filled('fecha_inicio'), fn ($query, $fecha) => $query->whereDate('created_at', '>=', $fecha));
        $query->when($request->filled('fecha_fin'), fn ($query, $fecha) => $query->whereDate('created_at', '<=', $fecha));
        $query->when($request->filled('search'), function ($query, $search) {
            $query->where('codigo', 'like', '%' . $search . '%')
                ->orWhereHas('cultivo', fn ($query) => $query->where('nombre', 'like', '%' . $search . '%'));
        });

        $sort = in_array($request->query('sort'), ['id', 'codigo', 'cantidad_filas', 'cultivo_id', 'created_at'])
            ? $request->query('sort')
            : 'created_at';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $lotes = $query->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        $sumFilas = (clone $query)->sum('cantidad_filas');

        return view('lotes.index', compact('lotes', 'cultivos', 'estados', 'sumFilas'));
    }

    public function create()
    {
        $this->authorize('create', Lote::class);
        $cultivos = Cultivo::where('estado', true)->get();
        return view('lotes.create', compact('cultivos'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Lote::class);
        
        $validated = $request->validate([
            'codigo' => 'required|unique:lotes',
            'cultivo_id' => 'required|exists:cultivos,id',
            'cantidad_filas' => 'required|integer|min:1',
            'estado' => 'nullable|boolean',
        ]);

        $validated['estado'] = isset($validated['estado']) ? (bool) $validated['estado'] : false;
        Lote::create($validated);
        return redirect()->route('lotes.index')->with('success', 'Lote registrado correctamente.');
    }

    public function show(Lote $lote)
    {
        $this->authorize('view', $lote);
        $lote->load('cultivo');
        return view('lotes.show', compact('lote'));
    }

    public function edit(Lote $lote)
    {
        $this->authorize('update', $lote);
        $cultivos = Cultivo::where('estado', true)->get();
        return view('lotes.edit', compact('lote', 'cultivos'));
    }

    public function update(Request $request, Lote $lote)
    {
        $this->authorize('update', $lote);
        
        $validated = $request->validate([
            'codigo' => 'required|unique:lotes,codigo,' . $lote->id,
            'cultivo_id' => 'required|exists:cultivos,id',
            'cantidad_filas' => 'required|integer|min:1',
            'estado' => 'nullable|boolean',
        ]);

        $validated['estado'] = isset($validated['estado']) ? (bool) $validated['estado'] : false;
        $lote->update($validated);
        return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(Lote $lote)
    {
        $this->authorize('delete', $lote);
        
        $lote->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado correctamente.');
    }
}
