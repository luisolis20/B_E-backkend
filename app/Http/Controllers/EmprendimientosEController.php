<?php

namespace App\Http\Controllers;

use App\Models\Emprendimientos;
use Illuminate\Http\Request;

class EmprendimientosEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = Emprendimientos::select('be_emprendimientos.*')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
                ->where('be_emprendimientos.estado_empren', 1);
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get();

                // Convertir los datos a UTF-8 válido
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if (is_string($value)) {
                            $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $attributes;
                });

                return response()->json(['data' => $data]);
            }

            // Paginación por defecto
            $data = $query->paginate(20);

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron datos'], 404);
            }

            // Convertir los datos de cada página a UTF-8 válido
            $data->getCollection()->transform(function ($item) {
                $attributes = $item->getAttributes();
                foreach ($attributes as $key => $value) {
                    if (is_string($value)) {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $attributes;
            });

            // Retornar respuesta JSON con metadatos de paginación
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        if (!empty($inputs['fotografia'])) {
            $inputs['fotografia'] = base64_decode($inputs['fotografia']);
        }
        $res = Emprendimientos::create($inputs);
        // Clonar el modelo y convertir fotografia en base64
        $data = $res->toArray();
        if (!empty($res->fotografia)) {
            $data['fotografia'] = base64_encode($res->fotografia);
        }

        return response()->json([
            'data' => $data,
            'mensaje' => "Agregado con Éxito!!",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data =  Emprendimientos::join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
            ->where('informacionpersonal.CIInfPer', $id)
            ->select('be_emprendimientos.*', 'informacionpersonal.ApellInfPer', 'informacionpersonal.ApellMatInfPer','informacionpersonal.NombInfPer')
            ->paginate(20);
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (is_string($value)) {
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
        if (isset($res)) {
            $res->estado = 0;
            $res->save();

            return response()->json([
                'data' => $res,
                'mensaje' => "Empresa desactivada con éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Empresa con id: $id no Existe",
            ]);
        }
    }
}
