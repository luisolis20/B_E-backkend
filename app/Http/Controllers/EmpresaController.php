<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = Empresa::select('praempresa.*');
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
                    if ($key === 'imagen' && !empty($value)) {
                        // ✅ Convertir BLOB a base64
                        $attributes[$key] = base64_encode($value);
                    } elseif (is_string($value) && $key !== 'imagen') {
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
        if (!empty($inputs['imagen'])) {
            $inputs['imagen'] = base64_decode($inputs['imagen']);
        }
        $res = Empresa::create($inputs);
        // Clonar el modelo y convertir imagen en base64
        $data = $res->toArray();
        if (!empty($res->imagen)) {
            $data['imagen'] = base64_encode($res->imagen);
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
        try {
            $data =  Empresa::join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
                ->where('be_users.id', $id)
                ->select('praempresa.*')
                ->paginate(20);
            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
            }

            // Convertir los campos a UTF-8 válido para cada página
            $data->getCollection()->transform(function ($item) {
                $attributes = $item->getAttributes();
                foreach ($attributes as $key => $value) {
                    if ($key === 'imagen' && !empty($value)) {
                        // ✅ Convertir BLOB a base64
                        $attributes[$key] = base64_encode($value);
                    } elseif (is_string($value) && $key !== 'imagen') {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $attributes;
            });

            // Retornar la respuesta JSON con los metadatos de paginación

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
    public function ver_empresa(string $id)
    {
        $res = Empresa::find($id);
        if (isset($res)) {
            // Verificar si la imagen existe y codificarla en base64
            $res->imagen = $res->imagen ? base64_encode($res->imagen) : null;
            return response()->json([
                'data' => $res,
                'mensaje' => "Encontrado con Éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Empresa con id: $id no Existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = Empresa::find($id);
        if (isset($res)) {
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
            $res->tipo = $request->tipo;
            $res->titulo = $request->titulo;
            $res->representante = $request->representante;
            $res->cargo = $request->cargo;
            $res->actividad = $request->actividad;
            $res->fechafin = $request->fechafin;
            $res->ciudad = $request->ciudad;
            $res->estado_empr = $request->estado_empr;
            $res->tipoinstitucion = $request->tipoinstitucion;
            if (!empty($request->imagen)) {
                $res->imagen = base64_decode($request->imagen);
            }
            $res->usuario_id = $request->usuario_id;
            if ($res->save()) {
                $data = $res->toArray();
                if (!empty($res->imagen)) {
                    $data['imagen'] = base64_encode($res->imagen);
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
                'mensaje' => "La Empresa con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $res = Empresa::find($id);
        if (isset($res)) {
            $res->estado_empr = 0;
            $res->save();

            return response()->json([
                'data' => $res,
                'mensaje' => "Empresa inhabilitada con éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Empresa con id: $id no Existe",
            ]);
        }
    }
}
