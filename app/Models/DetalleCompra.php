<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_compra';
    protected $primaryKey = 'id_detalle';
    
    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id', 'id_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Inventario::class, 'producto_id', 'id_producto');
    }
}