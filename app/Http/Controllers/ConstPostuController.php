<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use Illuminate\Http\Request;

class ConstPostuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $res = Postulacion::select(
            'postulacions_be.id',
            'empresas_be.nombre as Empresa',
            'oferta__empleos_be.titulo as Oferta',
            'oferta__empleos_be.descripcion',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'informacionpersonal.CelularInfPer',
            'informacionpersonal.DirecDomicilioPer',
            'postulacions_be.created_at'
        )
        ->join('oferta__empleos_be', 'oferta__empleos_be.id', '=', 'postulacions_be.oferta_id')
        ->join('empresas_be', 'empresas_be.id', '=', 'oferta__empleos_be.empresa_id')
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'postulacions_be.CIInfPer')
        ->where('postulacions_be.id', $id)
        ->get();
    
        if ($res->count() > 0) {
            return response()->json([
                'data' => $res,
                'mensaje' => "Encontrado con Éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "No se encontraron postulaciones para los criterios dados",
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
