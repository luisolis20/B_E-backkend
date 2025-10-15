<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguiPreguntas extends Model
{
   // Nombre de la tabla en la base de datos
    protected $table = 'seguipreguntas';
    // Clave primaria
    protected $primaryKey = 'ID';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'PREGUNTA',
        'IDFORMULARIO',
        'UP',
        'FINS',
        'UD',
        'FDEL',
        'tipo',
    ];

    // Relación con la tabla seguiformulario
    public function seguiformulario()
    {
        return $this->belongsTo(SeguiFormulario::class, 'IDFORMULARIO');
    }
    // Relación con la tabla seguitiporespuesta
    public function seguitiporespuesta()
    {
        return $this->hasMany(SeguiTipoRespuesta::class, 'IDPREGUNTA', 'ID');
    }
    // Relación con la tabla seguidendetalencuesta
    public function seguidendetalencuesta()
    {
        return $this->hasMany(SeguiDetalleEncuesta::class, 'idpregunta', 'ID');
    }
}
