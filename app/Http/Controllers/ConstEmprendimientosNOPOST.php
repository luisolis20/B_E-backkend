<?php

namespace App\Http\Controllers;

use App\Models\Emprendimientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InteraccionesEmprendimiento;

class ConstEmprendimientosNOPOST extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user_id; // El ID del usuario debe enviarse desde el frontend
    
        // Verificar si el usuario tiene alguna interacción previa con un emprendimiento
        $interacciones = InteraccionesEmprendimiento::select('interacciones_emprendimientos.emprendimiento_id')
            ->where('CIInfPer', $userId)
            ->pluck('emprendimiento_id')
            ->toArray();

        if (empty($interacciones)) {
            // Si no hay interacciones, mostrar todos los emprendimientos
            $emprendimientos = Emprendimientos::select(
                    'be_emprendimientos.id',
                    'be_emprendimientos.nombre',
                    'be_emprendimientos.descripcion',
                    'be_emprendimientos.fotografia',
                    'be_emprendimientos.tiempo_emprendimiento',
                    'be_emprendimientos.horarios',
                    'be_emprendimientos.direccion',
                    'be_emprendimientos.fecha_caducidad_oferta_emprend',
                    'be_emprendimientos.CIInfPer',
                    'informacionpersonal.nombres as propietario'
                )
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer');
            
            if ($request->has('all') && $request->all === 'true') {
                $data = $emprendimientos->get();
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
            $emprendimientos = Emprendimientos::select(
                    'be_emprendimientos.id',
                    'be_emprendimientos.nombre',
                    'be_emprendimientos.descripcion',
                    'be_emprendimientos.fotografia',
                    'be_emprendimientos.tiempo_emprendimiento',
                    'be_emprendimientos.horarios',
                    'be_emprendimientos.direccion',
                    'be_emprendimientos.fecha_caducidad_oferta_emprend',
                    'be_emprendimientos.CIInfPer',
                    'informacionpersonal.nombres as propietario'
                )
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
                ->whereNotIn('be_emprendimientos.id', $interacciones);

            if ($request->has('all') && $request->all === 'true') {
                $data = $emprendimientos->get();
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
    public function show(string $id)
    {
       
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
