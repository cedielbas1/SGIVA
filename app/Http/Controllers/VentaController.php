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

    public function index()
    {
        $ventas = Venta::with('cultivo', 'lote')->paginate(15);
        return view('ventas.index', compact('ventas'));
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

        $request->validate([
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

        $request->validate([
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
