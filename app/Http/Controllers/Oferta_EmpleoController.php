<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Oferta_EmpleoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = Oferta_Empleo::select(
                'oferta__empleos_be.id',
                'oferta__empleos_be.empresa_id',
                'praempresa.empresacorta as Empresa',
                'praempresa.ruc',
                'oferta__empleos_be.titulo',
                'oferta__empleos_be.descripcion',
                'oferta__empleos_be.categoria',
                'oferta__empleos_be.fechaFinOferta',
                'oferta__empleos_be.requisistos as Requisitos',
                'oferta__empleos_be.jornada',
                'oferta__empleos_be.modalidad',
                'oferta__empleos_be.tipo_contrato',
                'oferta__empleos_be.estado_ofert',
                'oferta__empleos_be.updated_at',
                'praempresa.representante as Jefe',
                'oferta__empleos_be.created_at',
                DB::raw('COUNT(postulacions_be.id) as total_postulados') // 🔹 Conteo de postulados
            )
                ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
                ->leftJoin('postulacions_be', 'postulacions_be.oferta_id', '=', 'oferta__empleos_be.id') // 🔹 unir postulaciones
                ->groupBy(
                    'oferta__empleos_be.id',
                    'oferta__empleos_be.empresa_id',
                    'praempresa.empresacorta',
                    'praempresa.ruc',
                    'oferta__empleos_be.titulo',
                    'oferta__empleos_be.descripcion',
                    'oferta__empleos_be.categoria',
                    'oferta__empleos_be.fechaFinOferta',
                    'oferta__empleos_be.requisistos',
                    'oferta__empleos_be.jornada',
                    'oferta__empleos_be.modalidad',
                    'oferta__empleos_be.tipo_contrato',
                    'oferta__empleos_be.estado_ofert',
                    'oferta__empleos_be.updated_at',
                    'praempresa.representante',
                    'oferta__empleos_be.created_at'
                );

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
                return response()->json([
                    'data' => [],
                    'message' => 'No se encontraron datos'
                ], 200);
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
        $res = Oferta_Empleo::create($inputs);
        return response()->json([
            'data' => $res,
            'mensaje' => "Agregado con Éxito!!",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Oferta_Empleo::select(
            'oferta__empleos_be.id',
            'oferta__empleos_be.empresa_id',
            'praempresa.empresacorta as Empresa',
            'praempresa.ruc',
            'oferta__empleos_be.titulo',
            'oferta__empleos_be.descripcion',
            'oferta__empleos_be.categoria',
            'oferta__empleos_be.fechaFinOferta',
            'oferta__empleos_be.requisistos as Requisitos',
            'oferta__empleos_be.jornada',
            'oferta__empleos_be.modalidad',
            'oferta__empleos_be.tipo_contrato',
            'oferta__empleos_be.estado_ofert',
            'oferta__empleos_be.updated_at',
            'praempresa.representante as Jefe',
            'oferta__empleos_be.created_at',
            DB::raw('COUNT(postulacions_be.id) as total_postulados') // 🔹 Conteo de postulados
        )
            ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
            ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
            ->leftJoin('postulacions_be', 'postulacions_be.oferta_id', '=', 'oferta__empleos_be.id') // 🔹 unir postulaciones
            ->groupBy(
                'oferta__empleos_be.id',
                'oferta__empleos_be.empresa_id',
                'praempresa.empresacorta',
                'praempresa.ruc',
                'oferta__empleos_be.titulo',
                'oferta__empleos_be.descripcion',
                'oferta__empleos_be.categoria',
                'oferta__empleos_be.fechaFinOferta',
                'oferta__empleos_be.requisistos',
                'oferta__empleos_be.jornada',
                'oferta__empleos_be.modalidad',
                'oferta__empleos_be.tipo_contrato',
                'oferta__empleos_be.estado_ofert',
                'oferta__empleos_be.updated_at',
                'praempresa.representante',
                'oferta__empleos_be.created_at'
            )
            ->where('be_users.id', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No se encontraron datos'
            ], 200);
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
        $res = Oferta_Empleo::find($id);
        if (isset($res)) {
            $res->titulo = $request->titulo;
            $res->descripcion = $request->descripcion;
            $res->requisistos = $request->requisistos;
            $res->jornada = $request->jornada;
            $res->tipo_contrato = $request->tipo_contrato;
            $res->modalidad = $request->modalidad;
            $res->categoria = $request->categoria;
            $res->fechaFinOferta = $request->fechaFinOferta;
            $res->estado_ofert = $request->estado_ofert;
            $res->empresa_id = $request->empresa_id;
            if ($res->save()) {
                return response()->json([
                    'data' => $res,
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
                'mensaje' => "La Oferta de Empleo con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Oferta_Empleo::find($id);
        if (isset($res)) {
            $res->estado_ofert = 0;
            $res->save();
            $data = $res->toArray();
            if ($data) {

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Inhabilitado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $data,
                    'mensaje' => "La Empresa no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Empresa con id: $id no Existe",
            ]);
        }
    }
    public function habilitar(string $id)
    {
        $res = Oferta_Empleo::find($id);
        if (isset($res)) {
            $res->estado_ofert = 1;
            $res->save();
            $data = $res->toArray();
            if ($data) {

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Eliminado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $data,
                    'mensaje' => "La Empresa no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Empresa con id: $id no Existe",
            ]);
        }
    }
}
