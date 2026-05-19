<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Lote;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $actividades = Actividad::with('usuario', 'lote.cultivo')->paginate(15);
        return view('actividades.index', compact('actividades'));
    }

    public function create()
    {
        $this->authorize('create', Actividad::class);
        $lotes = Lote::with('cultivo')->get();
        return view('actividades.create', compact('lotes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Actividad::class);

        $request->validate([
            'tipo_actividad' => 'required|string|max:100',
            'lote_id' => 'required|exists:lotes,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $data = $validated;
        $data['user_id'] = auth()->id();

        Actividad::create($data);
        return redirect()->route('actividades.index')->with('success', 'Actividad registrada correctamente.');
    }

    public function show(Actividad $actividad)
    {
        $this->authorize('view', $actividad);
        $actividad->load('usuario', 'lote.cultivo');
        return view('actividades.show', compact('actividad'));
    }

    public function edit(Actividad $actividad)
    {
        $this->authorize('update', $actividad);
        $lotes = Lote::with('cultivo')->get();
        return view('actividades.edit', compact('actividad', 'lotes'));
    }

    public function update(Request $request, Actividad $actividad)
    {
        $this->authorize('update', $actividad);

        $validated = $request->validate([
            'tipo_actividad' => 'required|string|max:100',
            'lote_id' => 'required|exists:lotes,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $actividad->update($validated);
        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(Actividad $actividad)
    {
        $this->authorize('delete', $actividad);
        
        $actividad->delete();
        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada correctamente.');
    }
}
