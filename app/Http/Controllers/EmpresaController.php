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
        return Empresa::join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
        ->where('be_users.id', $id)
        ->select('praempresa.*')
        ->get();
       
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
