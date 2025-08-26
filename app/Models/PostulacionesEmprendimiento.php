<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionesEmprendimiento extends Model
{ 
    protected $table = 'be_postulacions_empren';
    protected $primaryKey = 'id';

    protected $fillable = [
        'CIInfPer',
        'oferta_emp_id',
    ];

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimientos::class, 'oferta_emp_id');
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
