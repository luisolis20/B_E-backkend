<?php

namespace App\Http\Controllers;

use App\Models\PostulacionesEmprendimiento;
use Illuminate\Http\Request;

class InteraccionesEmprendimientos2Controller extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = PostulacionesEmprendimiento::select(
                'be_postulacions_empren.id',
                'be_emprendimientos.nombre_emprendimiento as Empresa',
                'be_oferta_empleos_empre.titulo as Oferta',
                'be_oferta_empleos_empre.descripcion',
                'postulante.CIInfPer',
                'postulante.ApellInfPer',
                'postulante.ApellMatInfPer',
                'postulante.NombInfPer',
                'postulante.mailPer',
                'be_estado_postulaciones_emprend.id as estado_id',
                'be_estado_postulaciones_emprend.estado',
                'be_estado_postulaciones_emprend.detalle_estado',
                'be_postulacions_empren.created_at'
            )
                ->join('be_oferta_empleos_empre', 'be_oferta_empleos_empre.id', '=', 'be_postulacions_empren.oferta_emp_id')
                ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
                ->join('informacionpersonal as dueño', 'dueño.CIInfPer', '=', 'be_emprendimientos.CIInfPer') // dueño del emprendimiento
                ->join('informacionpersonal as postulante', 'postulante.CIInfPer', '=', 'be_postulacions_empren.CIInfPer') // postulante
                ->leftJoin('be_estado_postulaciones_emprend', 'be_estado_postulaciones_emprend.postulacion_empren_id', '=', 'be_postulacions_empren.id')
                ->where('dueño.CIInfPer', $request->CIInfPer); // usuario dueño del emprendimiento

            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get()->map(function ($item) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (is_string($value)) {
                            $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $item;
                });
                return response()->json(['data' => $data]);
            }

            $data = $query->paginate(20);

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron interacciones'], 404);
            }

            $data->getCollection()->transform(function ($item) {
                foreach ($item->getAttributes() as $key => $value) {
                    if (is_string($value)) {
                        $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $item;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $res = PostulacionesEmprendimiento::create($inputs);
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
        $data = PostulacionesEmprendimiento::select(
            'be_postulacions_empren.id',
            'be_emprendimientos.nombre_emprendimiento as Empresa',
            'be_oferta_empleos_empre.titulo as Oferta',
            'be_oferta_empleos_empre.descripcion',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'be_estado_postulaciones_emprend.id as estado_id',
            'be_estado_postulaciones_emprend.estado',
            'be_estado_postulaciones_emprend.detalle_estado',
            'be_postulacions_empren.created_at'
        )
            ->join('be_oferta_empleos_empre', 'be_oferta_empleos_empre.id', '=', 'be_postulacions_empren.oferta_emp_id')
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_oferta_empleos_empre.emprendimiento_id')
            ->join('be_estado_postulaciones_emprend', 'be_estado_postulaciones_emprend.postulacion_empren_id', '=', 'be_postulacions_empren.id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_postulacions_empren.CIInfPer')
            ->where('be_oferta_empleos_empre.id', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron interacciones para este emprendimiento'], 404);
        }

        $data->getCollection()->transform(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (is_string($value)) {
                    $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $item;
        });

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $res = PostulacionesEmprendimiento::find($id);
        if (isset($res)) {
            $res->CIInfPer = $request->CIInfPer;
            $res->oferta_emp_id = $request->oferta_emp_id;
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
                'mensaje' => "La Postulación de Empleo con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = PostulacionesEmprendimiento::find($id);
        if (isset($res)) {
            $elim = PostulacionesEmprendimiento::destroy($id);
            if ($elim) {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "Eliminado con Éxito!!",
                ]);
            } else {
                return response()->json([
                    'data' => $res,
                    'mensaje' => "no existe (puede que ya la haya eliminado)",
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => " $id no Existe",
            ]);
        }
    }
}
