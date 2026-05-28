<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Inventario;
use App\Models\DetalleCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor', 'detalleCompras.producto')->orderBy('id_compra', 'desc')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Inventario::orderBy('nombre')->get();
        return view('compras.crear', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id_proveedor',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo_producto' => 'required|in:existente,nuevo',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $producto_id = null;
            $subtotal = $request->cantidad * $request->precio;

            if ($request->tipo_producto === 'existente') {
                $request->validate([
                    'producto_id' => 'required|exists:inventario,id_producto'
                ]);
                $producto_id = $request->producto_id;
                $producto = Inventario::find($producto_id);
            } else {
                $request->validate([
                    'codigo' => 'required|unique:inventario,codigo',
                    'nombre_producto' => 'required|unique:inventario,nombre',
                    'categoria' => 'required',
                    'laboratorio' => 'required'
                ]);

                $producto = Inventario::create([
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre_producto,
                    'precio' => $request->precio,
                    'stock' => 0,
                    'categoria' => $request->categoria,
                    'presentacion' => $request->presentacion ?? 'No especificada',
                    'laboratorio' => $request->laboratorio
                ]);
                $producto_id = $producto->id_producto;
            }

            // Actualizar stock del producto
            $producto->stock += $request->cantidad;
            $producto->save();

            // Crear compra
            $compra = Compra::create([
                'proveedor_id' => $request->proveedor_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'total' => $subtotal
            ]);

            // Crear detalle de compra
            DetalleCompra::create([
                'compra_id' => $compra->id_compra,
                'producto_id' => $producto_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio,
                'subtotal' => $subtotal
            ]);

            DB::commit();

            $mensaje = $request->tipo_producto === 'existente' 
                ? 'Compra registrada correctamente' 
                : 'Compra registrada y producto nuevo creado correctamente';

            return redirect()->route('compras.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al registrar la compra: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $compra = Compra::with('detalleCompras.producto')->findOrFail($id);
        $proveedores = Proveedor::all();
        $productos = Inventario::orderBy('nombre')->get();
        return view('compras.editar', compact('compra', 'proveedores', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        $detalleViejo = $compra->detalleCompras->first();
        $productoViejo = $detalleViejo->producto;
        
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id_proveedor',
            'fecha' => 'required|date',
            'hora' => 'required',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            // Restaurar stock anterior
            $productoViejo->stock -= $detalleViejo->cantidad;
            $productoViejo->save();

            $producto_id = null;
            $subtotal = $request->cantidad * $request->precio;

            if ($request->tipo_producto === 'existente') {
                $request->validate(['producto_id' => 'required|exists:inventario,id_producto']);
                $producto_id = $request->producto_id;
                $producto = Inventario::find($producto_id);
            } else {
                $request->validate([
                    'codigo' => 'required|unique:inventario,codigo,' . ($detalleViejo->producto_id ?? 'NULL'),
                    'nombre_producto' => 'required|unique:inventario,nombre,' . ($detalleViejo->producto_id ?? 'NULL'),
                    'categoria' => 'required',
                    'laboratorio' => 'required'
                ]);

                if ($detalleViejo->producto_id) {
                    $producto = $productoViejo;
                    $producto->update([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre_producto,
                        'categoria' => $request->categoria,
                        'laboratorio' => $request->laboratorio,
                        'presentacion' => $request->presentacion ?? $producto->presentacion,
                        'precio' => $request->precio
                    ]);
                    $producto_id = $producto->id_producto;
                } else {
                    $producto = Inventario::create([
                        'codigo' => $request->codigo,
                        'nombre' => $request->nombre_producto,
                        'precio' => $request->precio,
                        'stock' => 0,
                        'categoria' => $request->categoria,
                        'presentacion' => $request->presentacion ?? 'No especificada',
                        'laboratorio' => $request->laboratorio
                    ]);
                    $producto_id = $producto->id_producto;
                }
            }

            // Actualizar stock con nueva cantidad
            $producto->stock += $request->cantidad;
            $producto->save();

            // Actualizar compra
            $compra->update([
                'proveedor_id' => $request->proveedor_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'total' => $subtotal
            ]);

            // Actualizar detalle
            $detalleViejo->update([
                'producto_id' => $producto_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio,
                'subtotal' => $subtotal
            ]);

            DB::commit();

            return redirect()->route('compras.index')
                ->with('success', 'Compra actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar la compra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar una compra y restaurar el stock de los productos.
     */
    public function destroy($id)
    {
        $compra = Compra::with('detalleCompras')->find($id);

        if (!$compra) {
            return redirect()->route('compras.index')
                ->with('error', 'La compra no existe.');
        }

        DB::beginTransaction();

        try {
            // Primero eliminar los detalles de compra directamente con Query Builder
            DB::table('detalle_compra')->where('compra_id', $id)->delete();
            
            // Luego eliminar la compra
            DB::table('compras')->where('id_compra', $id)->delete();

            DB::commit();

            return redirect()->route('compras.index')
                ->with('success', 'Compra eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('compras.index')
                ->with('error', 'Error al eliminar la compra: ' . $e->getMessage());
        }
    }
}