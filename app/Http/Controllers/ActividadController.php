<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Lote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $lotes = Lote::with('cultivo')->get();
        $usuarios = User::orderBy('name')->get();
        $tipos = Actividad::select('tipo_actividad')->distinct()->orderBy('tipo_actividad')->pluck('tipo_actividad');

        $query = Actividad::with('usuario', 'lote.cultivo');

        $query->when($request->filled('tipo_actividad'), fn ($query, $tipo) => $query->where('tipo_actividad', $tipo));
        $query->when($request->filled('lote_id'), fn ($query, $loteId) => $query->where('lote_id', $loteId));
        $query->when($request->filled('usuario_id'), fn ($query, $usuarioId) => $query->where('user_id', $usuarioId));
        $query->when($request->filled('fecha_inicio'), fn ($query, $fecha) => $query->whereDate('fecha', '>=', $fecha));
        $query->when($request->filled('fecha_fin'), fn ($query, $fecha) => $query->whereDate('fecha', '<=', $fecha));
        $query->when($request->filled('search'), function ($query, $search) {
            $query->where('tipo_actividad', 'like', '%' . $search . '%')
                ->orWhere('observaciones', 'like', '%' . $search . '%')
                ->orWhereHas('lote', fn ($query) => $query->where('codigo', 'like', '%' . $search . '%'))
                ->orWhereHas('usuario', fn ($query) => $query->where('name', 'like', '%' . $search . '%'));
        });

        $sort = in_array($request->query('sort'), ['id', 'tipo_actividad', 'fecha', 'user_id', 'lote_id'])
            ? $request->query('sort')
            : 'fecha';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $actividades = $query->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        $totalesPorTipo = (clone $query)
            ->select('tipo_actividad', DB::raw('count(*) as total'))
            ->groupBy('tipo_actividad')
            ->reorder('tipo_actividad')
            ->get();

        return view('actividades.index', compact('actividades', 'lotes', 'usuarios', 'tipos', 'totalesPorTipo'));
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

        $validated = $request->validate([
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
