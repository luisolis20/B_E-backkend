<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'praempresa';
    protected $fillable = [
        'idempresa',
        'ruc',
        'empresacorta',
        'empresa',
        'pais',
        'lugar',
        'mision',
        'direccion',
        'telefono',
        'email',
        'url',
        'logo',
        'tipo',
        'titulo',
        'representante',
        'cargo',
        'actividad',
        'fechafin',
        'tipoinstitucion',
        'imagen',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function ofertasEmpleo()
    {
        return $this->hasMany(Oferta_Empleo::class, 'id_empresa');
    }
}
