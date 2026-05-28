<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Inventario::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:inventario',
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required',
            'presentacion' => 'required',
            'laboratorio' => 'required'
        ]);

        Inventario::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit($id)
    {
        $producto = Inventario::findOrFail($id);
        return view('productos.editar', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Inventario::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required',
            'presentacion' => 'required',
            'laboratorio' => 'required'
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Eliminar un producto.
     * Primero verifica si tiene ventas o compras asociadas.
     */
    public function destroy($id)
    {
        $producto = Inventario::find($id);

        if (!$producto) {
            return redirect()->route('productos.index')
                ->with('error', 'El producto no existe.');
        }

        // Verificar si el producto tiene ventas asociadas
        $tieneVentas = DB::table('detalle_venta')->where('producto_id', $id)->exists();
        
        // Verificar si el producto tiene compras asociadas
        $tieneCompras = DB::table('detalle_compra')->where('producto_id', $id)->exists();

        if ($tieneVentas || $tieneCompras) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque tiene ventas o compras asociadas.');
        }

        try {
            $producto->delete();
            return redirect()->route('productos.index')
                ->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}