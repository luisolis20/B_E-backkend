<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprendimientos extends Model
{
   // Nombre de la tabla en la base de datos
    protected $table = 'be_emprendimientos';
    // Clave primaria
    protected $primaryKey = 'id';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'ruc',
        'CIInfPer',
        'nombre_emprendimiento',
        'descripcion',
        'logo',
        'fotografia',
        'fotografia2',
        'tiempo_emprendimiento',
        'horarios_atencion',
        'direccion',
        'telefono_contacto',
        'email_contacto',
        'sitio_web',
        'redes_sociales',
        'estado_empren'
    ];


    // Relación con la tabla informacionpersonal
    public function informacionPersonal()
    {
        return $this->belongsTo(InformacionPersonal::class, 'CIInfPer', 'CIInfPer');
    }
    // Relación con la tabla interacciones_emprendimientos
    public function interacciones()
    {
        return $this->hasMany(Oferta_Empleo_Empre::class, 'emprendimiento_id', 'id');
    }
}
