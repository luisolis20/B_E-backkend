<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta_Empleo extends Model
{
    use HasFactory;
    public $table = "oferta__empleos_be";
    protected $fillable = [
        'titulo',
        'descripcion',
        'requisistos', 
        'jornada',
        'tipo_contrato',
        'modalidad',
        'categoria',
        'id_empresa',
    ];

    
     public function empresa()
     {
         return $this->belongsTo(Empresa::class, 'id_empresa');
     }
 
     
     public function postulaciones()
     {
         return $this->hasMany(Postulacion::class, 'oferta_id');
     }
}
