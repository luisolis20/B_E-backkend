<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'praempresa';
    protected $primaryKey = 'idempresa';
    //public $timestamps = false;
    protected $fillable = [
        'idempresa',
        'ruc',
        'empresa',
        'empresacorta',
        'lugar',
        'direccion',
        'telefono',
        'email',
        'url',
        'tipo',
        'titulo',
        'representante',
        'cargo',
        'actividad',
        'fechafin',
        'tipoinstitucion',
        'pais',
        'vision',
        'mision',
        'estado_empr',
        'imagen',
        'ciudad',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function ofertasEmpleo()
    {
        return $this->hasMany(Oferta_Empleo::class, 'empresa_id');
    }
}
