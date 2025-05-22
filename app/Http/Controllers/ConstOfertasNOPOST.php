<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Postulacion;

class ConstOfertasNOPOST extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user_id; // El ID del usuario debe enviarse desde el frontend
    
       // Verificar si el usuario tiene alguna postulación
            $postulaciones = Postulacion::select('postulacions_be.*')
            ->where('CIInfPer', $userId)
            ->pluck('oferta_id')
            ->toArray();

        // Si el usuario no tiene postulaciones, devolver todas las ofertas
        if (empty($postulaciones)) {
            $ofertas = Oferta_Empleo::select('oferta__empleos_be.id', 'oferta__empleos_be.empresa_id', 'praempresa.empresacorta as Empresa', 
                'oferta__empleos_be.titulo', 'oferta__empleos_be.descripcion', 'oferta__empleos_be.categoria', 
                'oferta__empleos_be.requisistos as Requisitos', 'oferta__empleos_be.jornada', 'oferta__empleos_be.modalidad', 
                'oferta__empleos_be.tipo_contrato', 'praempresa.representante as Jefe', 'oferta__empleos_be.created_at')
                ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
                ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
                ->get();
        } else {
            // Devolver solo las ofertas a las que el usuario no ha postulado
            $ofertas = Oferta_Empleo::select('oferta__empleos_be.id', 'oferta__empleos_be.empresa_id', 'praempresa.empresacorta as Empresa', 
                'oferta__empleos_be.titulo', 'oferta__empleos_be.descripcion', 'oferta__empleos_be.categoria', 
                'oferta__empleos_be.requisistos as Requisitos', 'oferta__empleos_be.jornada', 'oferta__empleos_be.modalidad', 
                'oferta__empleos_be.tipo_contrato', 'praempresa.representante as Jefe', 'oferta__empleos_be.created_at')
                ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
                ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
                ->whereNotIn('oferta__empleos_be.id', $postulaciones) // Excluir las ofertas en las que el usuario ya ha postulado
                ->get();
        }

        return response()->json($ofertas);
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
