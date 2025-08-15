<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteraccionesEmprendimiento extends Model
{ 
    protected $table = 'interacciones_emprendimientos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'CIInfPer',
        'emprendimiento_id',
        'tipo_interaccion',
        'fecha_interaccion'
    ];

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimientos::class, 'emprendimiento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(InformacionPersonal::class, 'CIInfPer', 'CIInfPer');
    }
}
