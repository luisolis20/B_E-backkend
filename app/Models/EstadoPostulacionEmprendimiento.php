<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPostulacionEmprendimiento extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'be_estado_postulaciones_emprend';

    // Campos que pueden ser llenados masivamente
    protected $fillable = [
        'postulacion_empren_id',
        'estado',
        'detalle_estado',
        'fecha',
    ];

    /**
     * Relación con la tabla postulacions.
     * Un estado de postulación pertenece a una postulación.
     */
    public function postulacion()
    {
        return $this->belongsTo(PostulacionesEmprendimiento::class, 'postulacion_empren_id');
    }
}
