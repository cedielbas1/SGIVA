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

    public function index()
    {
        $insumos = Insumo::with('cultivo')->paginate(15);
        return view('insumos.index', compact('insumos'));
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
