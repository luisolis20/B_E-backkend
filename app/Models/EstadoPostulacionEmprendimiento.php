<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPostulacionEmprendimiento extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'be_estado_postulaciones_emprendimientos';

    // Campos que pueden ser llenados masivamente
    protected $fillable = [
        'interaccion_id',
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
        return $this->belongsTo(InteraccionesEmprendimiento::class, 'interaccion_id');
    }
}
