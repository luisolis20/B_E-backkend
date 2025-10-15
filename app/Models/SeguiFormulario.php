<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguiFormulario extends Model
{
   // Nombre de la tabla en la base de datos
    protected $table = 'seguiformulario';
    // Clave primaria
    protected $primaryKey = 'ID';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'ID',
        'NOMBRE',
        'ACTIVO',
        'UP',
        'FINS',
        'UD',
        'FDEL',
        'TOTAL',
        'porcentaje',
        'tipoencuesta',
    ];

    // Relación con la tabla seguipreguntas
    public function seguipreguntas()
    {
        return $this->hasMany(SeguiPreguntas::class, 'IDFORMULARIO', 'ID');
    }
    // Relación con la tabla seguiencuesta
    public function seguiencuesta()
    {
        return $this->hasMany(SeguiEncuesta::class, 'idformulario', 'ID');
    }
}
