<?php

namespace App\Http\Controllers;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConstPostUsersEstadoController extends Controller
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
            'praempresa.empresacorta as Empresa',
            'oferta__empleos_be.titulo as Oferta',
            'oferta__empleos_be.categoria',
           'estado_postulaciones_be.estado',
            'postulacions_be.created_at'
        )
        ->join('oferta__empleos_be', 'oferta__empleos_be.id', '=', 'postulacions_be.oferta_id')
        ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
        ->join('estado_postulaciones_be', 'estado_postulaciones_be.postulacion_id', '=', 'postulacions_be.id')
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
        $res = Postulacion::find($id);
        if(isset($res)){
            $elim = Postulacion::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La postulación no exite (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La postulación con id: $id no Existe",
            ]);
        }
    }
}
