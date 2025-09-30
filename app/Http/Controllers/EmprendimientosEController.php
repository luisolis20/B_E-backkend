<?php

namespace App\Http\Controllers;

use App\Models\Emprendimientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmprendimientosEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $query = Emprendimientos::select(
                'be_emprendimientos.id',
                'be_emprendimientos.ruc',
                'be_emprendimientos.nombre_emprendimiento',
                'be_emprendimientos.descripcion',
                'be_emprendimientos.fotografia',
                'be_emprendimientos.tiempo_emprendimiento',
                'be_emprendimientos.horarios_atencion',
                'be_emprendimientos.direccion',
                'be_emprendimientos.telefono_contacto',
                'be_emprendimientos.email_contacto',
                'be_emprendimientos.sitio_web',
                'be_emprendimientos.redes_sociales',
                'be_emprendimientos.estado_empren',
                'be_emprendimientos.updated_at',
                'be_emprendimientos.created_at',
                'informacionpersonal.CIInfPer',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                DB::raw('COUNT(be_oferta_empleos_empre.id) as total_ofertas'), // 🔹 
            )
                ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
                ->leftJoin('be_oferta_empleos_empre', 'be_oferta_empleos_empre.emprendimiento_id', '=', 'be_emprendimientos.id') // 🔹
                ->groupBy(
                    'be_emprendimientos.id',
                    'be_emprendimientos.ruc',
                    'be_emprendimientos.nombre_emprendimiento',
                    'be_emprendimientos.descripcion',
                    'be_emprendimientos.fotografia',
                    'be_emprendimientos.tiempo_emprendimiento',
                    'be_emprendimientos.horarios_atencion',
                    'be_emprendimientos.direccion',
                    'be_emprendimientos.telefono_contacto',
                    'be_emprendimientos.email_contacto',
                    'be_emprendimientos.sitio_web',
                    'be_emprendimientos.redes_sociales',
                    'be_emprendimientos.estado_empren',
                    'be_emprendimientos.updated_at',
                    'be_emprendimientos.created_at',
                    'informacionpersonal.CIInfPer',
                    'informacionpersonal.ApellInfPer',
                    'informacionpersonal.ApellMatInfPer',
                    'informacionpersonal.NombInfPer',
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
                return response()->json(['error' => 'No se encontraron datos'], 404);
            }

            // Convertir los datos de cada página a UTF-8 válido
            $data->getCollection()->transform(function ($item) {
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
        if (!empty($inputs['fotografia'])) {
            $inputs['fotografia'] = base64_decode($inputs['fotografia']);
        }
        $res = Emprendimientos::create($inputs);
        // Clonar el modelo y convertir fotografia en base64
        $data = $res->toArray();
        if (!empty($res->fotografia)) {
            $data['fotografia'] = base64_encode($res->fotografia);
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
        $data =  Emprendimientos::select(
            'be_emprendimientos.id',
            'be_emprendimientos.ruc',
            'be_emprendimientos.nombre_emprendimiento',
            'be_emprendimientos.descripcion',
            'be_emprendimientos.fotografia',
            'be_emprendimientos.tiempo_emprendimiento',
            'be_emprendimientos.horarios_atencion',
            'be_emprendimientos.direccion',
            'be_emprendimientos.telefono_contacto',
            'be_emprendimientos.email_contacto',
            'be_emprendimientos.sitio_web',
            'be_emprendimientos.redes_sociales',
            'be_emprendimientos.estado_empren',
            'be_emprendimientos.updated_at',
            'be_emprendimientos.created_at',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            DB::raw('COUNT(be_oferta_empleos_empre.id) as total_ofertas') // 🔹 
        )
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
            ->leftJoin('be_oferta_empleos_empre', 'be_oferta_empleos_empre.emprendimiento_id', '=', 'be_emprendimientos.id') // 🔹
            ->groupBy(
                'be_emprendimientos.id',
                'be_emprendimientos.ruc',
                'be_emprendimientos.nombre_emprendimiento',
                'be_emprendimientos.descripcion',
                'be_emprendimientos.fotografia',
                'be_emprendimientos.tiempo_emprendimiento',
                'be_emprendimientos.horarios_atencion',
                'be_emprendimientos.direccion',
                'be_emprendimientos.telefono_contacto',
                'be_emprendimientos.email_contacto',
                'be_emprendimientos.sitio_web',
                'be_emprendimientos.redes_sociales',
                'be_emprendimientos.estado_empren',
                'be_emprendimientos.updated_at',
                'be_emprendimientos.created_at',
                'informacionpersonal.CIInfPer',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
            )
            ->where('informacionpersonal.CIInfPer', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if ($key === 'fotografia' && !empty($value)) {
                    // Convertir BLOB a base64
                    $attributes[$key] = base64_encode($value);
                } elseif (is_string($value) && $key !== 'fotografia') {
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
    public function ver_emprendimiento(string $id)
    {
        $data =  Emprendimientos::select(
            'be_emprendimientos.id',
            'be_emprendimientos.ruc',
            'be_emprendimientos.nombre_emprendimiento',
            'be_emprendimientos.descripcion',
            'be_emprendimientos.fotografia',
            'be_emprendimientos.tiempo_emprendimiento',
            'be_emprendimientos.horarios_atencion',
            'be_emprendimientos.direccion',
            'be_emprendimientos.telefono_contacto',
            'be_emprendimientos.email_contacto',
            'be_emprendimientos.sitio_web',
            'be_emprendimientos.redes_sociales',
            'be_emprendimientos.estado_empren',
            'be_emprendimientos.updated_at',
            'be_emprendimientos.created_at',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            DB::raw('COUNT(be_oferta_empleos_empre.id) as total_ofertas') // 🔹 
        )
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
            ->leftJoin('be_oferta_empleos_empre', 'be_oferta_empleos_empre.emprendimiento_id', '=', 'be_emprendimientos.id') // 🔹
            ->groupBy(
                'be_emprendimientos.id',
                'be_emprendimientos.ruc',
                'be_emprendimientos.nombre_emprendimiento',
                'be_emprendimientos.descripcion',
                'be_emprendimientos.fotografia',
                'be_emprendimientos.tiempo_emprendimiento',
                'be_emprendimientos.horarios_atencion',
                'be_emprendimientos.direccion',
                'be_emprendimientos.telefono_contacto',
                'be_emprendimientos.email_contacto',
                'be_emprendimientos.sitio_web',
                'be_emprendimientos.redes_sociales',
                'be_emprendimientos.estado_empren',
                'be_emprendimientos.updated_at',
                'be_emprendimientos.created_at',
                'informacionpersonal.CIInfPer',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
            )
            ->where('be_emprendimientos.id', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
        $data->getCollection()->transform(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if ($key === 'fotografia' && !empty($value)) {
                    // Convertir BLOB a base64
                    $attributes[$key] = base64_encode($value);
                } elseif (is_string($value) && $key !== 'fotografia') {
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
        $res = Emprendimientos::find($id);
        if (isset($res)) {
            $res->ruc = $request->ruc;
            $res->CIInfPer = $request->CIInfPer;
            $res->nombre_emprendimiento = $request->nombre_emprendimiento;
            $res->descripcion = $request->descripcion;
            if (!empty($request->fotografia)) {
                $res->fotografia = base64_decode($request->fotografia);
            }
            $res->tiempo_emprendimiento = $request->tiempo_emprendimiento;
            $res->horarios_atencion = $request->horarios_atencion;
            $res->direccion = $request->direccion;
            $res->telefono_contacto = $request->telefono_contacto;
            $res->email_contacto = $request->email_contacto;
            $res->sitio_web = $request->sitio_web;
            $res->redes_sociales = $request->redes_sociales;
            $res->estado_empren = $request->estado_empren;
            if ($res->save()) {
                $data = $res->toArray();
                if (!empty($res->fotografia)) {
                    $data['fotografia'] = base64_encode($res->fotografia);
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
                'mensaje' => "El emprendimiento con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Emprendimientos::find($id);
        if (isset($res)) {
            $res->estado = 0;
            $res->save();

            return response()->json([
                'data' => $res,
                'mensaje' => "Emprendimiento inhabilitado con éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El Emprendimiento con id: $id no Existe",
            ]);
        }
    }
}
