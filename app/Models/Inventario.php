<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';
    protected $primaryKey = 'id_producto';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'precio',
        'stock',
        'categoria',
        'presentacion',
        'laboratorio'
    ];

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id', 'id_producto');
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'producto_id', 'id_producto');
    }
}