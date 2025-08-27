<?php

namespace App\Http\Controllers;

use App\Models\Emprendimientos;
use App\Models\Oferta_Empleo_Empre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PostulacionesEmprendimiento;

class ConstEmprendimientosNOPOST extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user_id; // El ID del usuario debe enviarse desde el frontend

        // Verificar si el usuario tiene alguna interacción previa con un emprendimiento
        $interacciones = PostulacionesEmprendimiento::select('be_postulacions_empren.*')
            ->where('CIInfPer', $userId)
            ->pluck('oferta_emp_id')
            ->toArray();

        if (empty($interacciones)) {
            // Si no hay interacciones, mostrar todos los emprendimientos
            $emprendimientos = Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Empresa',
                'be_emprendimientos.fotografia',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_emprendimientos.CIInfPer',
                'be_oferta_empleos_empre.created_at'
            )
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer');

            if ($request->has('all') && $request->all === 'true') {
                $data = $emprendimientos->get();
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if ($key === 'fotografia' && !empty($value)) {
                            // ✅ Convertir BLOB a base64
                            $attributes[$key] = base64_encode($value);
                        } elseif (is_string($value) && $key !== 'fotografia') {
                            $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $attributes;
                });
                return response()->json(['data' => $data]);
            }

            $data = $emprendimientos->paginate(20);
            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron datos'], 404);
            }
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
            // Mostrar solo los emprendimientos que el usuario NO haya visitado/postulado
            $emprendimientos = Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Empresa',
                'be_emprendimientos.fotografia',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_emprendimientos.CIInfPer',
                'be_oferta_empleos_empre.created_at'
            )
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
                ->whereNotIn('be_oferta_empleos_empre.id', $interacciones);

            if ($request->has('all') && $request->all === 'true') {
                $data = $emprendimientos->get();
                $data->transform(function ($item) {
                    $attributes = $item->getAttributes();
                    foreach ($attributes as $key => $value) {
                        if ($key === 'fotografia' && !empty($value)) {
                            // ✅ Convertir BLOB a base64
                            $attributes[$key] = base64_encode($value);
                        } elseif (is_string($value) && $key !== 'fotografia') {
                            $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $attributes;
                });
                return response()->json(['data' => $data]);
            }

            $data = $emprendimientos->paginate(20);
            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron datos'], 404);
            }
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
