<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Postulacion;

class ConstOfertasNOPOST extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user_id; // El ID del usuario debe enviarse desde el frontend

        // Verificar si el usuario tiene alguna postulación
        $postulaciones = Postulacion::select('postulacions_be.*')
            ->where('CIInfPer', $userId)
            ->pluck('oferta_id')
            ->toArray();

        // Si el usuario no tiene postulaciones, devolver todas las ofertas
        if (empty($postulaciones)) {
            $ofertas = Oferta_Empleo::select(
                'oferta__empleos_be.id',
                'oferta__empleos_be.empresa_id',
                'praempresa.empresacorta as Empresa',
                'oferta__empleos_be.titulo',
                'oferta__empleos_be.descripcion',
                'oferta__empleos_be.categoria',
                'oferta__empleos_be.fechaFinOferta',
                'oferta__empleos_be.requisistos as Requisitos',
                'oferta__empleos_be.jornada',
                'oferta__empleos_be.modalidad',
                'oferta__empleos_be.tipo_contrato',
                'oferta__empleos_be.estado_ofert',
                'praempresa.representante as Jefe',
                'oferta__empleos_be.created_at'
            )
                ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
                ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
                ->where('oferta__empleos_be.estado_ofert','=', 1);
            if ($request->has('all') && $request->all === 'true') {
                $data = $ofertas->get();

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
            $data = $ofertas->paginate(20);

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
        } else {
            // Devolver solo las ofertas a las que el usuario no ha postulado
            $ofertas = Oferta_Empleo::select(
                'oferta__empleos_be.id',
                'oferta__empleos_be.empresa_id',
                'praempresa.empresacorta as Empresa',
                'oferta__empleos_be.titulo',
                'oferta__empleos_be.descripcion',
                'oferta__empleos_be.categoria',
                'oferta__empleos_be.fechaFinOferta',
                'oferta__empleos_be.requisistos as Requisitos',
                'oferta__empleos_be.jornada',
                'oferta__empleos_be.modalidad',
                'oferta__empleos_be.tipo_contrato',
                'oferta__empleos_be.estado_ofert',
                'praempresa.representante as Jefe',
                'oferta__empleos_be.created_at'
            )
                ->join('praempresa', 'praempresa.idempresa', '=', 'oferta__empleos_be.empresa_id')
                ->join('be_users', 'be_users.id', '=', 'praempresa.usuario_id')
                ->where('oferta__empleos_be.estado_ofert','=', 1)
                ->whereNotIn('oferta__empleos_be.id', $postulaciones); // Excluir las ofertas en las que el usuario ya ha postulado
            if ($request->has('all') && $request->all === 'true') {
                $data = $ofertas->get();

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
            $data = $ofertas->paginate(20);

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
        }

        try {
            return response()->json([
                'data' => $ofertas->items(),
                'current_page' => $ofertas->currentPage(),
                'per_page' => $ofertas->perPage(),
                'total' => $ofertas->total(),
                'last_page' => $ofertas->lastPage(),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
