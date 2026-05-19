<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\Request;

class CultivoController extends Controller
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
        $cultivos = Cultivo::all();
        return view('cultivos.index', compact('cultivos'));
    }

    public function create()
    {
        $this->authorize('create', Cultivo::class);
        return view('cultivos.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Cultivo::class);
        
        $validated = $request->validate([
            'nombre' => 'required|unique:cultivos|max:255',
            'estado' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['estado'] = (bool) ($data['estado'] ?? false);
        
        Cultivo::create($data);
        return redirect()->route('cultivos.index')->with('success', 'Cultivo creado exitosamente.');
    }

    public function show(Cultivo $cultivo)
    {
        $this->authorize('view', $cultivo);
        return view('cultivos.show', compact('cultivo'));
    }

    public function edit(Cultivo $cultivo)
    {
        $this->authorize('update', $cultivo);
        return view('cultivos.edit', compact('cultivo'));
    }

    public function update(Request $request, Cultivo $cultivo)
    {
        $this->authorize('update', $cultivo);
        
        $validated = $request->validate([
            'nombre' => 'required|max:255|unique:cultivos,nombre,' . $cultivo->id,
            'estado' => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['estado'] = (bool) ($data['estado'] ?? false);
        
        $cultivo->update($data);
        return redirect()->route('cultivos.index')->with('success', 'Cultivo actualizado.');
    }

    public function destroy(Cultivo $cultivo)
    {
        $this->authorize('delete', $cultivo);
        
        $cultivo->delete();
        return redirect()->route('cultivos.index')->with('success', 'Cultivo eliminado.');
    }
}
