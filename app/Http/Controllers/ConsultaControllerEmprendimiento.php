<?php

namespace App\Http\Controllers;
use App\Models\Emprendimientos;
use Illuminate\Http\Request;

class ConsultaControllerEmprendimiento extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Emprendimientos::all();
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
        $res = Emprendimientos::find($id);
        if(isset($res)){
            $data = $res->toArray();
            if (!empty($res->fotografia)) {
                $data['fotografia'] = base64_encode($res->fotografia);
            }

            return response()->json([
                'data' => $data,
                'mensaje' => "Usuario Encontrado con Éxito!!",
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
        
        $res = Emprendimientos::find($id);
        if (isset($res)) {
            $res->ruc = $request->ruc;
            $res->CIInfPer = $request->CIInfPer;
            $res->nombre_emprendimiento = $request->nombre_emprendimiento;
            $res->descripcion = $request->descripcion;
            
           
            if (!empty($res->fotografia)) {
                $res->fotografia = base64_decode($res->fotografia);
            }else{
                $res->fotografia = null;
            }
            $res->tiempo_emprendimiento = $request->tiempo_emprendimiento;
            $res->horarios_atencion = $request->horarios_atencion;
            $res->direccion = $request->direccion;
            $res->telefono_contacto = $request->telefono_contacto;
            $res->email_contacto = $request->email_contacto;
            $res->sitio_web = $request->sitio_web;
            $res->redes_sociales = $request->redes_sociales;
            $res->estado_empren = $request->estado_empren;
            if ($res->save()) {
                 $data = $res->toArray();
                if (!empty($res->fotografia)) {
                    $data['fotografia'] = base64_encode($res->fotografia);
                }
                return response()->json([
                    'data' => $data,
                    'mensaje' => "Actualizado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'mensaje' => "Error al Actualizar",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El emprendimiento con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Emprendimientos::find($id);
        if(isset($res)){
            $elim = Emprendimientos::destroy($id);
            $data = $res->toArray();
            if (!empty($res->fotografia)) {
                $data['fotografia'] = base64_encode($res->fotografia);
            }
            if($elim){
           
                return response()->json([
                    'data'=>$data,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$data,
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
