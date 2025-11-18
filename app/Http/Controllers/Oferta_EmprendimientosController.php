<?php

namespace App\Http\Controllers;

use App\Models\Oferta_Empleo_Empre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Oferta_EmprendimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query =  Oferta_Empleo_Empre::select(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.requisistos as Requisitos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'be_oferta_empleos_empre.estado_ofert_empr',
                'be_oferta_empleos_empre.updated_at',
                'be_emprendimientos.CIInfPer',
                'be_emprendimientos.email_contacto',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_oferta_empleos_empre.created_at',
                DB::raw('COUNT(be_postulacions_empren.id) as total_postulados') // 🔹 Conteo de postulados
            )
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
                ->leftJoin('be_postulacions_empren', 'be_postulacions_empren.oferta_emp_id', '=', 'be_oferta_empleos_empre.id') // 🔹 unir postulaciones
                ->groupBy(
                    'be_oferta_empleos_empre.id',
                    'be_oferta_empleos_empre.emprendimiento_id',
                    'be_emprendimientos.nombre_emprendimiento',
                    'be_oferta_empleos_empre.titulo',
                    'be_oferta_empleos_empre.descripcion',
                    'be_oferta_empleos_empre.categoria',
                    'be_oferta_empleos_empre.fechaFinOferta',
                    'be_oferta_empleos_empre.requisistos',
                    'be_oferta_empleos_empre.jornada',
                    'be_oferta_empleos_empre.modalidad',
                    'be_oferta_empleos_empre.tipo_contrato',
                    'be_oferta_empleos_empre.estado_ofert_empr',
                    'be_oferta_empleos_empre.updated_at',
                    'be_emprendimientos.CIInfPer',
                    'be_emprendimientos.email_contacto',
                    'informacionpersonal.ApellInfPer',
                    'informacionpersonal.ApellMatInfPer',
                    'informacionpersonal.NombInfPer',
                    'be_oferta_empleos_empre.created_at'
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
        $res = Oferta_Empleo_Empre::create($inputs);
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
        $data = Oferta_Empleo_Empre::select(
            'be_oferta_empleos_empre.id',
            'be_oferta_empleos_empre.emprendimiento_id',
            'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
            'be_oferta_empleos_empre.titulo',
            'be_oferta_empleos_empre.descripcion',
            'be_oferta_empleos_empre.categoria',
            'be_oferta_empleos_empre.fechaFinOferta',
            'be_oferta_empleos_empre.requisistos as Requisitos',
            'be_oferta_empleos_empre.jornada',
            'be_oferta_empleos_empre.modalidad',
            'be_oferta_empleos_empre.tipo_contrato',
            'be_oferta_empleos_empre.estado_ofert_empr',
            'be_oferta_empleos_empre.updated_at',
            'be_emprendimientos.CIInfPer',
            'be_emprendimientos.email_contacto',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'be_oferta_empleos_empre.created_at',
            DB::raw('COUNT(be_postulacions_empren.id) as total_postulados') // 🔹 Conteo de postulados
        )
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
            ->leftJoin('be_postulacions_empren', 'be_postulacions_empren.oferta_emp_id', '=', 'be_oferta_empleos_empre.id') // 🔹 unir postulaciones
            ->groupBy(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.requisistos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'be_oferta_empleos_empre.estado_ofert_empr',
                'be_oferta_empleos_empre.updated_at',
                'be_emprendimientos.CIInfPer',
                'be_emprendimientos.email_contacto',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_oferta_empleos_empre.created_at'
            )
            ->where('informacionpersonal.CIInfPer', $id)
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
    public function ver_oferta_emprendimiento(string $id)
    {
        $data = Oferta_Empleo_Empre::select(
            'be_oferta_empleos_empre.id',
            'be_oferta_empleos_empre.emprendimiento_id',
            'be_emprendimientos.nombre_emprendimiento as Emprendimiento',
            'be_oferta_empleos_empre.titulo',
            'be_oferta_empleos_empre.descripcion',
            'be_oferta_empleos_empre.categoria',
            'be_oferta_empleos_empre.fechaFinOferta',
            'be_oferta_empleos_empre.requisistos as Requisitos',
            'be_oferta_empleos_empre.jornada',
            'be_oferta_empleos_empre.modalidad',
            'be_oferta_empleos_empre.tipo_contrato',
            'be_oferta_empleos_empre.estado_ofert_empr',
            'be_oferta_empleos_empre.updated_at',
            'be_emprendimientos.CIInfPer',
            'be_emprendimientos.email_contacto',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'be_oferta_empleos_empre.created_at',
            DB::raw('COUNT(be_postulacions_empren.id) as total_postulados') // 🔹 Conteo de postulados
        )
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
            ->leftJoin('be_postulacions_empren', 'be_postulacions_empren.oferta_emp_id', '=', 'be_oferta_empleos_empre.id') // 🔹 unir postulaciones
            ->groupBy(
                'be_oferta_empleos_empre.id',
                'be_oferta_empleos_empre.emprendimiento_id',
                'be_emprendimientos.nombre_emprendimiento',
                'be_oferta_empleos_empre.titulo',
                'be_oferta_empleos_empre.descripcion',
                'be_oferta_empleos_empre.categoria',
                'be_oferta_empleos_empre.fechaFinOferta',
                'be_oferta_empleos_empre.requisistos',
                'be_oferta_empleos_empre.jornada',
                'be_oferta_empleos_empre.modalidad',
                'be_oferta_empleos_empre.tipo_contrato',
                'be_oferta_empleos_empre.estado_ofert_empr',
                'be_oferta_empleos_empre.updated_at',
                'be_emprendimientos.CIInfPer',
                'be_emprendimientos.email_contacto',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'be_oferta_empleos_empre.created_at'
            )
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
        $res = Oferta_Empleo_Empre::find($id);

        if ($res) {
            $res->update($request->all());

            return response()->json([
                'data' => $res,
                'mensaje' => "Actualizado con Éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Oferta de Empleo con id: $id no existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Oferta_Empleo_Empre::find($id);
        if (isset($res)) {
            $res->estado_ofert_empr = 0;
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
                    'mensaje' => "La Oferta de Empleo no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Oferta de Empleo con id: $id no Existe",
            ]);
        }
    }
    public function habilitar(string $id)
    {
        $res = Oferta_Empleo_Empre::find($id);
        if (isset($res)) {
            $res->estado_ofert_empr = 1;
            $res->save();
            $data = $res->toArray();
            if ($data) {

                return response()->json([
                    'data' => $data,
                    'mensaje' => "Habilitado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $data,
                    'mensaje' => "La Oferta de Empleo no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Oferta de Empleo con id: $id no Existe",
            ]);
        }
    }
}
