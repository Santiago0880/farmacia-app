<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $rol = $user->rol ?? 'vendedor';

        // Estadísticas principales
        $totalProductos = Inventario::count();
        $totalVentas = Venta::count();
        $totalClientes = Cliente::count();
        $totalProveedores = ($rol === 'administrador') ? Proveedor::count() : 0;
        $productosAgotados = Inventario::where('stock', 0)->count();
        
        // Productos con bajo stock
        $productosBajoStock = Inventario::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(6)
            ->get();
        
        // Productos más vendidos
        $productosMasVendidos = DB::table('detalle_venta')
            ->join('inventario', 'detalle_venta.producto_id', '=', 'inventario.id_producto')
            ->select('inventario.id_producto', 'inventario.codigo', 'inventario.nombre', 'inventario.stock', 
                DB::raw('SUM(detalle_venta.cantidad) as total_vendido'))
            ->groupBy('detalle_venta.producto_id', 'inventario.id_producto', 'inventario.codigo', 'inventario.nombre', 'inventario.stock')
            ->orderBy('total_vendido', 'desc')
            ->limit(6)
            ->get();
        
        // Ventas por mes
        $ventasPorMes = DB::table('ventas')
            ->select(DB::raw('DATE_FORMAT(fecha, "%Y-%m") as mes'), DB::raw('COUNT(*) as total_ventas'), DB::raw('SUM(total) as monto_total'))
            ->groupBy(DB::raw('DATE_FORMAT(fecha, "%Y-%m")'))
            ->orderBy('mes', 'desc')
            ->limit(6)
            ->get();
        
        return view('dashboard.index', compact(
            'totalProductos', 
            'totalVentas', 
            'totalClientes', 
            'totalProveedores',
            'productosBajoStock',
            'productosMasVendidos',
            'ventasPorMes',
            'productosAgotados'
        ));
    }
}