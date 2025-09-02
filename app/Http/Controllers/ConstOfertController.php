<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo;
use Illuminate\Http\Request;

class ConstOfertController extends Controller
{ 
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        return Oferta_Empleo::select(
            'oferta__empleos_be.id',
            'oferta__empleos_be.empresa_id',
            'praempresa.empresacorta as Empresa',
            'oferta__empleos_be.titulo',
            'oferta__empleos_be.descripcion',
            'oferta__empleos_be.categoria',
            'oferta__empleos_be.requisistos as Requisitos',
            'oferta__empleos_be.jornada',
            'oferta__empleos_be.modalidad',
            'oferta__empleos_be.tipo_contrato',
            'praempresa.representante as Jefe',
            'oferta__empleos_be.created_at'
        )
            ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
            ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = Oferta_Empleo::select(
            'oferta__empleos_be.id',
            'oferta__empleos_be.empresa_id',
            'praempresa.empresacorta as Empresa',
            'praempresa.lugar',
            'praempresa.telefono',
            'praempresa.direccion',
            'oferta__empleos_be.titulo',
            'oferta__empleos_be.descripcion',
            'oferta__empleos_be.categoria',
            'oferta__empleos_be.fechaFinOferta',
            'oferta__empleos_be.jornada',
            'oferta__empleos_be.modalidad',
            'oferta__empleos_be.tipo_contrato',
            'oferta__empleos_be.requisistos as Requisitos',
            'praempresa.representante as Jefe',
            'oferta__empleos_be.created_at'
        )
            ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
            ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
            ->where('oferta__empleos_be.id', $id)
            ->get();

        if ($res) {
            return response()->json([
                'data' => $res,
                'mensaje' => "Encontrado con Éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Oferta de Empleo no Existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
