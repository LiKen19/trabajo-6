<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';


    protected $fillable = [
        'cliente_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}
