<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguiTipoRespuesta extends Model
{
   // Nombre de la tabla en la base de datos
    protected $table = 'seguitiporespuesta';
    // Clave primaria
    protected $primaryKey = 'ID';
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'TIPORESPUESTA',
        'IDPREGUNTA',
        'UP',
        'FINS',
        'UD',
        'FDEL',
        'valor',
    ];

    // Relación con la tabla seguipreguntas
    public function seguipreguntas()
    {
        return $this->belongsTo(SeguiPreguntas::class, 'IDPREGUNTA');
    }
    // Relación con la tabla seguidendetalencuesta
    public function seguidendetalencuesta()
    {
        return $this->hasMany(SeguiDetalleEncuesta::class, 'idtiporespuesta', 'ID');
    }

}
