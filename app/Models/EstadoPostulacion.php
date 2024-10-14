<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPostulacion extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'estado_postulaciones_be';

    // Campos que pueden ser llenados masivamente
    protected $fillable = [
        'postulacion_id',
        'estado',
        'fecha',
    ];

    /**
     * Relación con la tabla postulacions.
     * Un estado de postulación pertenece a una postulación.
     */
    public function postulacion()
    {
        return $this->belongsTo(Postulacion::class, 'postulacion_id');
    }
}
