<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteraccionesEmprendimiento extends Model
{ 
    protected $table = 'be_interacciones_emprendimientos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'CIInfPer',
        'emprendimiento_id',
    ];

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimientos::class, 'emprendimiento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(InformacionPersonal::class, 'CIInfPer', 'CIInfPer');
    }
    public function estadosPostulacion()
    {
        return $this->hasMany(EstadoPostulacionEmprendimiento::class, 'interaccion_id', 'id');
    }
}
