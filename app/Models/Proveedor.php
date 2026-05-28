<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    
    protected $fillable = [
        'nit',
        'nombre',
        'telefono',
        'email'
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'proveedor_id', 'id_proveedor');
    }
}