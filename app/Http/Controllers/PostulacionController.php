<?php

namespace App\Http\Controllers;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Postulacion::select(
            'postulacions_be.id',
            'empresas_be.nombre as Empresa',
            'oferta__empleos_be.titulo as Oferta',
            'oferta__empleos_be.descripcion',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'postulacions_be.created_at'
        )
        ->join('oferta__empleos_be', 'oferta__empleos_be.id', '=', 'postulacions_be.oferta_id')
        ->join('empresas_be', 'empresas_be.id', '=', 'oferta__empleos_be.empresa_id')
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'postulacions_be.CIInfPer')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $res = Postulacion::create($inputs);
        return response()->json([
            'data'=>$res,
            'mensaje'=>"Agregado con Éxito!!",
        ]);
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
            'postulacions_be.created_at'
        )
        ->join('oferta__empleos_be', 'oferta__empleos_be.id', '=', 'postulacions_be.oferta_id')
        ->join('empresas_be', 'empresas_be.id', '=', 'oferta__empleos_be.empresa_id')
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'postulacions_be.CIInfPer')
        ->where('oferta__empleos_be.id', $id)
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
       
        $res = Postulacion::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->oferta_id = $request->oferta_id;
            if($res->save()){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Actualizado con Éxito!!",
                ]);
            }
            else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>"Error al Actualizar",
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Postulación de Empleo con id: $id no Existe",
            ]);
        }
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
                    'mensaje'=>"La Oferta_Empleo no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Oferta_Empleo con id: $id no Existe",
            ]);
        }
    }
}
