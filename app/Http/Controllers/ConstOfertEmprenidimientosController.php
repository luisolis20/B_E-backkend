<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo_Empre;
use Illuminate\Http\Request;

class ConstOfertEmprenidimientosController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $res = Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Empresa',
                'be_emprendimientos.fotografia',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_oferta_empleos_empre.created_at'
            )
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_postulacions_empren.CIInfPer')
            ->get();
            if ($res) {
                $data = $res->toArray();
                if (!empty($res->fotografia)) {
                    $data['fotografia'] = base64_encode($res->fotografia);
                }
                return response()->json([
                    'data' => $data,
                    'mensaje' => "Encontrado con Éxito!!",
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos: ' . $e->getMessage()], 500);
        }
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
        try{

            $res = Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Empresa',
                'be_emprendimientos.fotografia',
                'be_emprendimientos.lugar',
                'be_emprendimientos.telefono',
                'be_emprendimientos.direccion',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_oferta_empleos_empre.created_at'
            )
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
            ->join('be_users', 'be_users.id', '=', 'be_emprendimientos.usuario_id')
            ->where('be_oferta_empleos_empre.id', $id)
            ->get();
    
            if ($res) {
                $data = $res->toArray();
                if (!empty($res->fotografia)) {
                    $data['fotografia'] = base64_encode($res->fotografia);
                }
                return response()->json([
                    'data' => $data,
                    'mensaje' => "Encontrado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => "La Oferta de Empleo no Existe",
                ]);
            }
        }catch(\Exception $e){
            return response()->json(['error' => 'Error al obtener los datos: ' . $e->getMessage()], 500);
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
