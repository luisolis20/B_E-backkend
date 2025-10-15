<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguiEncuesta extends Model
{
   // Nombre de la tabla en la base de datos
    protected $table = 'seguiencuesta';
    // Clave primaria
    protected $primaryKey = 'ID';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cedula_estudiante',
        'fecha',
        'idformulario',
        'idcarr',
        'encuestador',
    ];

    // Relación con la tabla seguiformulario
    public function seguiformulario()
    {
        return $this->belongsTo(SeguiFormulario::class, 'idformulario');
    }
}
