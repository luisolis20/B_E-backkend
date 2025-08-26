<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Empresa::all();
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
        $res = Empresa::find($id);
        if(isset($res)){
            return response()->json([
                'data'=>$res,
                'mensaje'=>"Encontrado con Éxito!!",
            ]);
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El Usuario con id: $id no Existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = Empresa::find($id);
        if(isset($res)){
            $res->ruc = $request->ruc;
            $res->empresa = $request->empresa;
            $res->empresacorta = $request->empresacorta;
            $res->pais = $request->pais;
            $res->lugar = $request->lugar;
            $res->vision = $request->vision;
            $res->mision = $request->mision;
            $res->direccion = $request->direccion;
            $res->telefono = $request->telefono;
            $res->email = $request->email;
            $res->url = $request->url;
            $res->logo = $request->logo;
            $res->tipo = $request->tipo;
            $res->titulo = $request->titulo;
            $res->representante = $request->representante;
            $res->cargo = $request->cargo;
            $res->actividad = $request->actividad;
            $res->fechafin = $request->fechafin;
            $res->tipoinstitucion = $request->tipoinstitucion;
            $res->imagen = $request->imagen;
            $res->usuario_id = $request->usuario_id;
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
                'mensaje'=>"La Empresa con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
