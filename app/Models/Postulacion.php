<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;
    protected $table = 'postulacions_be';
    protected $fillable = [
        'CIInfPer', 'oferta_id',
    ];   
    
     public function usuario()
     {
         return $this->belongsTo(informacionpersonal::class, 'CIInfPer');
     }
 
    
     public function ofertaEmpleo()
     {
         return $this->belongsTo(Oferta_Empleo::class, 'oferta_id');
     }
}
