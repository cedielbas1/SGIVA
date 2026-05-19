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

    public function index()
    {
        // Usamos 'with' para cargar el cultivo y evitar muchas consultas (Eager Loading)
        $lotes = Lote::with('cultivo')->get();
        return view('lotes.index', compact('lotes'));
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
            'estado' => 'nullable|string',
        ]);

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
            'estado' => 'nullable|string',
        ]);

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
