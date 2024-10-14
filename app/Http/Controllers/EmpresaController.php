<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
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
        $inputs = $request->input();
        $res = Empresa::create($inputs);
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
        return Empresa::join('users_be', 'users_be.id', '=', 'empresas_be.usuario_id')
        ->where('users_be.id', $id)
        ->select('empresas_be.*')
        ->get();
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = Empresa::find($id);
        if(isset($res)){
            $res->nombre = $request->nombre;
            $res->ciudad = $request->ciudad;
            $res->pais = $request->pais;
            $res->descripcion = $request->descripcion;
            $res->vision = $request->vision;
            $res->mision = $request->mision;
            $res->telefono = $request->telefono;
            $res->direccion = $request->direccion;
            $res->tipo_empresa = $request->tipo_empresa;
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
        $res = Empresa::find($id);
        if(isset($res)){
            $elim = Empresa::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Empresa no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Empresa con id: $id no Existe",
            ]);
        }
    }
}
