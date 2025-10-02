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
        $data =  Emprendimientos::select('be_emprendimientos.*')
            ->where('be_emprendimientos.id', $id)
            ->paginate(20);
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (in_array($key, ['logo', 'fotografia', 'fotografia2']) && !empty($value)) {
                    // ✅ Convertir BLOB a base64
                    $attributes[$key] = base64_encode($value);
                } elseif (is_string($value) && !in_array($key, ['fotografia', 'logo', 'fotografia2'])) {
                    $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $attributes;
        });

        // Retornar la respuesta JSON con los metadatos de paginación
        try {
            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al codificar los datos a JSON: ' . $e->getMessage()], 500);
        }
        /*$res = Emprendimientos::find($id);
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
        }*/
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
            if (!empty($request->logo)) {
                $res->logo = base64_decode($request->logo);
            }
            if (!empty($request->fotografia)) {
                $res->fotografia = base64_decode($request->fotografia);
            }
            if (!empty($request->fotografia2)) {
                $res->fotografia2 = base64_decode($request->fotografia2);
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
                if (!empty($res->logo)) {
                    $data['logo'] = base64_encode($res->logo);
                }
                if (!empty($res->fotografia)) {
                    $data['fotografia'] = base64_encode($res->fotografia);
                }
                if (!empty($res->fotografia2)) {
                    $data['fotografia2'] = base64_encode($res->fotografia2);
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
        if (isset($res)) {
            $res->estado_empren = 0;
            $res->save();
            $data = $res->toArray();
            if (!empty($res->logo)) {
                $data['logo'] = base64_encode($res->logo);
            }
            if (!empty($res->fotografia)) {
                $data['fotografia'] = base64_encode($res->fotografia);
            }
            if (!empty($res->fotografia2)) {
                $data['fotografia2'] = base64_encode($res->fotografia2);
            }
            if ($data) {

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Inhabilitado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $data,
                    'mensaje' => "El emprendimiento no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El emprendimiento con id: $id no Existe",
            ]);
        }
    }
    public function habilitar(string $id)
    {
        $res = Emprendimientos::find($id);
        if (isset($res)) {
            $res->estado_empren = 1;
            $res->save();
            $data = $res->toArray();
            if (!empty($res->logo)) {
                $data['logo'] = base64_encode($res->logo);
            }
            if (!empty($res->fotografia)) {
                $data['fotografia'] = base64_encode($res->fotografia);
            }
            if (!empty($res->fotografia2)) {
                $data['fotografia2'] = base64_encode($res->fotografia2);
            }
            if ($data) {

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Habilitado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $data,
                    'mensaje' => "EL Emprendimiento no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "EL Emprendimiento con id: $id no Existe",
            ]);
        }
    }
}
