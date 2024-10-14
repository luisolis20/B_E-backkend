<?php

namespace App\Http\Controllers;

use App\Models\EstadoPostulacion;
use Illuminate\Http\Request;

class ConstEstadoPOSTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EstadoPostulacion::all();
    
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $res = EstadoPostulacion::create($inputs);
        return response()->json([
            'data'=>$res,
            'mensaje'=>"Postulación Aceptada",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = EstadoPostulacion::select(
            'estado_postulaciones_be.id',
            'estado_postulaciones_be.postulacion_id',
            'estado_postulaciones_be.estado',
            'estado_postulaciones_be.fecha',
            'empresas_be.id as IDEmpresa',
            'empresas_be.nombre as Empresa',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'informacionpersonal.CelularInfPer',
            'informacionpersonal.DirecDomicilioPer',
            'oferta__empleos_be.titulo as Oferta',
            'oferta__empleos_be.id as IDOferta',
            'estado_postulaciones_be.created_at'
        )
        ->join('postulacions_be', 'postulacions_be.id', '=', 'estado_postulaciones_be.postulacion_id')
        ->join('oferta__empleos_be', 'oferta__empleos_be.id', '=', 'postulacions_be.oferta_id')
        ->join('empresas_be', 'empresas_be.id', '=', 'oferta__empleos_be.empresa_id')
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'postulacions_be.CIInfPer')
        ->where('informacionpersonal.CIInfPer', $id)
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
