<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cultivo;
use App\Models\Lote;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cultivos = Cultivo::where('estado', true)->orderBy('nombre')->get();
        $lotes = Lote::with('cultivo')->get();

        $query = Venta::with('cultivo', 'lote');

        $query->when($request->filled('cultivo_id'), fn ($query, $cultivoId) => $query->where('cultivo_id', $cultivoId));
        $query->when($request->filled('lote_id'), fn ($query, $loteId) => $query->where('lote_id', $loteId));
        $query->when($request->filled('fecha_inicio'), fn ($query, $fecha) => $query->whereDate('fecha_venta', '>=', $fecha));
        $query->when($request->filled('fecha_fin'), fn ($query, $fecha) => $query->whereDate('fecha_venta', '<=', $fecha));
        $query->when($request->filled('search'), function ($query, $search) {
            $query->whereHas('cultivo', fn ($query) => $query->where('nombre', 'like', '%' . $search . '%'))
                ->orWhereHas('lote', fn ($query) => $query->where('codigo', 'like', '%' . $search . '%'));
        });

        $sort = in_array($request->query('sort'), ['id', 'cultivo_id', 'lote_id', 'cantidad_vendida', 'precio_unitario', 'total', 'fecha_venta'])
            ? $request->query('sort')
            : 'fecha_venta';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $ventas = $query->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        $totales = [
            'cantidad_vendida' => (clone $query)->sum('cantidad_vendida'),
            'total' => (clone $query)->sum('total'),
        ];

        return view('ventas.index', compact('ventas', 'cultivos', 'lotes', 'totales'));
    }

    public function create()
    {
        $this->authorize('create', Venta::class);
        $cultivos = Cultivo::where('estado', true)->get();
        $lotes = Lote::with('cultivo')->get();
        return view('ventas.create', compact('cultivos', 'lotes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Venta::class);

        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'lote_id' => 'required|exists:lotes,id',
            'cantidad_vendida' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0.01',
            'fecha_venta' => 'required|date',
        ]);

        $data = $validated;
        $data['total'] = $data['cantidad_vendida'] * $data['precio_unitario'];

        Venta::create($data);
        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $this->authorize('view', $venta);
        $venta->load('cultivo', 'lote');
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $this->authorize('update', $venta);
        $cultivos = Cultivo::where('estado', true)->get();
        $lotes = Lote::with('cultivo')->get();
        return view('ventas.edit', compact('venta', 'cultivos', 'lotes'));
    }

    public function update(Request $request, Venta $venta)
    {
        $this->authorize('update', $venta);

        $validated = $request->validate([
            'cultivo_id' => 'required|exists:cultivos,id',
            'lote_id' => 'required|exists:lotes,id',
            'cantidad_vendida' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0.01',
            'fecha_venta' => 'required|date',
        ]);

        $data = $validated;
        $data['total'] = $data['cantidad_vendida'] * $data['precio_unitario'];

        $venta->update($data);
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        $this->authorize('delete', $venta);
        
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }
}
