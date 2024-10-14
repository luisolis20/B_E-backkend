<?php

namespace App\Http\Controllers;
use App\Models\Oferta_Empleo;
use Illuminate\Http\Request;

class Oferta_Empleo2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = Oferta_Empleo::select('oferta__empleos_be.*')
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
        $res = Oferta_Empleo::find($id);
        if(isset($res)){
            $res->titulo = $request->titulo;
            $res->descripcion = $request->descripcion;
            $res->requisistos = $request->requisistos;
            $res->jornada = $request->jornada;
            $res->tipo_contrato = $request->tipo_contrato;
            $res->modalidad = $request->modalidad;
            $res->categoria = $request->categoria;
            $res->empresa_id = $request->empresa_id;
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
                'mensaje'=>"La Oferta de Empleo con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Oferta_Empleo::find($id);
        if(isset($res)){
            $elim = Oferta_Empleo::destroy($id);
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
