<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable =[
        'cliente_id',
        'fecha_venta',
        'total_venta',
        'estado'
    ];
public function cliente() {

    return $this->belongsTo(cliente::class);
}
public function productos()
{
    return $this->belongsToMany(productos::class,'ventas_detalles')
    ->withPivot('cantidad','precio','subtotal');
}
public function detalles()
{
    return $this->hasMany(VentaDetalle::class);
}


}
