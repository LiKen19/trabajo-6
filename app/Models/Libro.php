<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'categoria_id',
        'idioma',
        'autor',
        'editorial',
        'estado',
    ];
    protected $hidden = ['categoria'];


    // 👇 Esto añadirá el campo "nombre_categoria" en el JSON automáticamente
    protected $appends = ['nombre_categoria'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    // 👇 Este accesor devuelve solo el nombre de la categoría
    public function getNombreCategoriaAttribute()
    {
        return $this->categoria ? $this->categoria->nombre : null;
    }
}
