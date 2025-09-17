<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta_Empleo_Empre extends Model
{
    use HasFactory;
    public $table = "be_oferta_empleos_empre";
    protected $fillable = [
        'titulo',
        'descripcion',
        'requisistos', 
        'jornada',
        'tipo_contrato',
        'modalidad',
        'categoria',
        'fechaFinOferta',
        'estado_ofert_empr',
        'emprendimiento_id',
    ];

    
     public function empremdimiento()
     {
         return $this->belongsTo(Emprendimientos::class, 'emprendimiento_id');
     }
 
     
     public function postulaciones()
     {
         return $this->hasMany(PostulacionesEmprendimiento::class, 'oferta_emp_id');
     }
    
}
