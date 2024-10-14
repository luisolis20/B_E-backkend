<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresas_be';
    protected $fillable = [
        'nombre',
        'ciudad',
        'pais',
        'descripcion',
        'vision',
        'mision',
        'telefono',
        'direccion',
        'tipo_empresa',
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
