<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Inventario;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Mostrar lista de ventas
     */
    public function index()
    {
        $ventas = Venta::with('cliente', 'detalleVentas.producto')->orderBy('id_venta', 'desc')->get();
        return view('ventas.index', compact('ventas'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Inventario::where('stock', '>', 0)->orderBy('nombre')->get();
        return view('ventas.crear', compact('clientes', 'productos'));
    }

    /**
     * Guardar nueva venta
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id_cliente',
            'fecha' => 'required|date',
            'hora' => 'required',
            'producto_id' => 'required|array',
            'producto_id.*' => 'exists:inventario,id_producto',
            'cantidad' => 'required|array',
            'cantidad.*' => 'integer|min:1',
            'precio' => 'required|array',
            'precio.*' => 'numeric|min:0',
            'total' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            $detalles = [];

            // Validar stock antes de procesar
            for ($i = 0; $i < count($request->producto_id); $i++) {
                $producto = Inventario::find($request->producto_id[$i]);
                if ($request->cantidad[$i] > $producto->stock) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}");
                }
            }

            // Crear venta
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'total' => $request->total
            ]);

            // Procesar detalles y actualizar stock
            for ($i = 0; $i < count($request->producto_id); $i++) {
                $producto = Inventario::find($request->producto_id[$i]);
                $subtotal = $request->cantidad[$i] * $request->precio[$i];

                DetalleVenta::create([
                    'venta_id' => $venta->id_venta,
                    'producto_id' => $request->producto_id[$i],
                    'cantidad' => $request->cantidad[$i],
                    'precio_unitario' => $request->precio[$i],
                    'subtotal' => $subtotal
                ]);

                // Actualizar stock
                $producto->stock -= $request->cantidad[$i];
                $producto->save();
            }

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta registrada correctamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al registrar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $venta = Venta::with('detalleVentas.producto')->findOrFail($id);
        $clientes = Cliente::all();
        $productos = Inventario::orderBy('nombre')->get();
        return view('ventas.editar', compact('venta', 'clientes', 'productos'));
    }

    /**
     * Actualizar venta
     */
    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id_cliente',
            'fecha' => 'required|date',
            'hora' => 'required',
            'producto_id' => 'required|array',
            'producto_id.*' => 'exists:inventario,id_producto',
            'cantidad' => 'required|array',
            'cantidad.*' => 'integer|min:1',
            'precio' => 'required|array',
            'precio.*' => 'numeric|min:0',
            'total' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {
            // 1. Restaurar stock anterior
            foreach ($venta->detalleVentas as $detalle) {
                $producto = Inventario::find($detalle->producto_id);
                $producto->stock += $detalle->cantidad;
                $producto->save();
                $detalle->delete();
            }

            // 2. Validar stock nuevo
            for ($i = 0; $i < count($request->producto_id); $i++) {
                $producto = Inventario::find($request->producto_id[$i]);
                if ($request->cantidad[$i] > $producto->stock) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}");
                }
            }

            // 3. Actualizar venta
            $venta->update([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'total' => $request->total
            ]);

            // 4. Crear nuevos detalles y actualizar stock
            for ($i = 0; $i < count($request->producto_id); $i++) {
                $producto = Inventario::find($request->producto_id[$i]);
                $subtotal = $request->cantidad[$i] * $request->precio[$i];

                DetalleVenta::create([
                    'venta_id' => $venta->id_venta,
                    'producto_id' => $request->producto_id[$i],
                    'cantidad' => $request->cantidad[$i],
                    'precio_unitario' => $request->precio[$i],
                    'subtotal' => $subtotal
                ]);

                // Actualizar stock (restar nueva cantidad)
                $producto->stock -= $request->cantidad[$i];
                $producto->save();
            }

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar venta
     */
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);

        DB::beginTransaction();

        try {
            // Restaurar stock
            foreach ($venta->detalleVentas as $detalle) {
                $producto = Inventario::find($detalle->producto_id);
                $producto->stock += $detalle->cantidad;
                $producto->save();
            }
            
            // Eliminar detalles y venta
            DetalleVenta::where('venta_id', $venta->id_venta)->delete();
            $venta->delete();

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada correctamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }
}