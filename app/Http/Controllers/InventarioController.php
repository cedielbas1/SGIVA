<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Lote;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $inventarios = Inventario::with('lote.cultivo')->paginate(15);
        return view('inventarios.index', compact('inventarios'));
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
