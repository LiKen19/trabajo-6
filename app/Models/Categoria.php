<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Una categoría tiene muchos libros
    public function libros()
    {
        return $this->hasMany(Libro::class);
    }
}
