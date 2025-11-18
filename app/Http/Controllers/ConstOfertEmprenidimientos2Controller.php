<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo_Empre;
use Illuminate\Http\Request;

class ConstOfertEmprenidimientos2Controller extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
                'be_emprendimientos.logo',
                'be_emprendimientos.fotografia',
                'be_emprendimientos.fotografia2',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_emprendimientos.telefono_contacto',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_oferta_empleos_empre.created_at'
            )
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_postulacions_empren.CIInfPer')
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
                    if (in_array($key, ['logo', 'fotografia', 'fotografia2']) && !empty($value)) {
                        // ✅ Convertir BLOB a base64
                        $attributes[$key] = base64_encode($value);
                    } elseif (is_string($value) && !in_array($key, ['fotografia', 'logo', 'fotografia2'])) {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $attributes;
            });



            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos: ' . $e->getMessage()], 500);
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
        try {

            $data = Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
                'be_emprendimientos.logo',
                'be_emprendimientos.fotografia',
                'be_emprendimientos.fotografia2',
                'be_emprendimientos.telefono_contacto',
                'be_emprendimientos.direccion',
                'be_emprendimientos.sitio_web',
                'be_emprendimientos.redes_sociales',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_postulacions_empren.*',
                'be_estado_postulaciones_emprend.*',
                'be_oferta_empleos_empre.created_at'
            )
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
                ->join('be_postulacions_empren', 'be_postulacions_empren.oferta_emp_id', '=', 'be_oferta_empleos_empre.id')
                ->join('be_estado_postulaciones_emprend', 'be_estado_postulaciones_emprend.postulacion_empren_id', '=', 'be_postulacions_empren.id')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
                ->where('be_oferta_empleos_empre.id', $id)
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
                    if (in_array($key, ['logo', 'fotografia', 'fotografia2']) && !empty($value)) {
                        // ✅ Convertir BLOB a base64
                        $attributes[$key] = base64_encode($value);
                    } elseif (is_string($value) && !in_array($key, ['fotografia', 'logo', 'fotografia2'])) {
                        $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $attributes;
            });



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
