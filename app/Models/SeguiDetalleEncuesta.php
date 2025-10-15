<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguiDetalleEncuesta extends Model
{
   // Nombre de la tabla en la base de datos
    protected $table = 'seguiencuesta';
    // Clave primaria
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'idseguiencuesta',
        'idpregunta',
        'idtiporespuesta',
        'textorespuesta',
    ];

    // Relación con la tabla seguiformulario
    public function seguiformulario()
    {
        return $this->belongsTo(SeguiFormulario::class, 'idformulario');
    }
    // Relación con la tabla seguipreguntas
    public function seguipreguntas()
    {
        return $this->belongsTo(SeguiPreguntas::class, 'idpregunta');
    }
    // Relación con la tabla seguitiporespuesta
    public function seguitiporespuesta()
    {
        return $this->belongsTo(SeguiTipoRespuesta::class, 'idtiporespuesta');
    }
}
