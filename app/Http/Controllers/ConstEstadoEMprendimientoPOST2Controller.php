<?php

namespace App\Http\Controllers;

use App\Models\EstadoPostulacionEmprendimiento;
use Illuminate\Http\Request;

class ConstEstadoEMprendimientoPOST2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = EstadoPostulacionEmprendimiento::select(
                'be_estado_postulaciones_emprendimientos.id',
                'be_estado_postulaciones_emprendimientos.interaccion_id',
                'be_estado_postulaciones_emprendimientos.estado',
                'be_estado_postulaciones_emprendimientos.fecha',
                'be_estado_postulaciones_emprendimientos.detalle_estado',
                'be_interacciones_emprendimientos.id as IDInteraccion',
                'be_emprendimientos.id as IDEmprendimiento',
                'be_emprendimientos.ruc',
                'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
                'informacionpersonal.CIInfPer',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'informacionpersonal.mailPer',
                'informacionpersonal.CelularInfPer',
                'informacionpersonal.DirecDomicilioPer',
                'be_estado_postulaciones_emprendimientos.created_at'
            )
                ->join('be_interacciones_emprendimientos', 'be_interacciones_emprendimientos.id', '=', 'be_estado_postulaciones_emprendimientos.interaccion_id')
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_interacciones_emprendimientos.emprendimiento_id')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_interacciones_emprendimientos.CIInfPer');
            // Verificar si se solicita todos los datos sin paginación
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
        $res = EstadoPostulacionEmprendimiento::create($inputs);
        return response()->json([
            'data' => $res,
            'mensaje' => "Postulación Aceptada",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = EstadoPostulacionEmprendimiento::select(
            'be_estado_postulaciones_emprendimientos.id',
            'be_estado_postulaciones_emprendimientos.interaccion_id',
            'be_estado_postulaciones_emprendimientos.estado',
            'be_estado_postulaciones_emprendimientos.fecha',
            'be_estado_postulaciones_emprendimientos.detalle_estado',
            'be_interacciones_emprendimientos.id as IDInteraccion',
            'be_emprendimientos.id as IDEmprendimiento',
            'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'informacionpersonal.CelularInfPer',
            'informacionpersonal.DirecDomicilioPer',
            'be_estado_postulaciones_emprendimientos.created_at'
        )
            ->join('be_interacciones_emprendimientos', 'be_interacciones_emprendimientos.id', '=', 'be_estado_postulaciones_emprendimientos.interaccion_id')
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_interacciones_emprendimientos.emprendimiento_id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_interacciones_emprendimientos.CIInfPer')
            ->where('be_interacciones_emprendimientos.id', $id)
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
