<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    
    protected $fillable = [
        'proveedor_id',
        'fecha',
        'hora',
        'total'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id', 'id_proveedor');
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'compra_id', 'id_compra');
    }
}