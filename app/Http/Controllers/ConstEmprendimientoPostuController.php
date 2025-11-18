<?php

namespace App\Http\Controllers;

use App\Models\PostulacionesEmprendimiento;
use Illuminate\Http\Request;

class ConstEmprendimientoPostuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = PostulacionesEmprendimiento::select(
            'be_postulacions_empren.id',
            'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
            'be_oferta_empleos_empre.titulo as Oferta',
            'be_oferta_empleos_empre.descripcion',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'informacionpersonal.CelularInfPer',
            'informacionpersonal.DirecDomicilioPer',
            'be_postulacions_empren.created_at'
        )
            ->join('be_oferta_empleos_empre', 'be_oferta_empleos_empre.id', '=', 'be_postulacions_empren.oferta_emp_id')
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_postulacions_empren.CIInfPer')
            ->where('be_postulacions_empren.id', $id)
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
