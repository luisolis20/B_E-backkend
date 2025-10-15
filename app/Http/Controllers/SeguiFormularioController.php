<?php

namespace App\Http\Controllers;

use App\Models\SeguiFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeguiFormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = SeguiFormulario::select(
                'seguiformulario.ID',
                'seguiformulario.NOMBRE',
                'seguiformulario.ACTIVO',
                'seguiformulario.UP',
                'seguiformulario.FINS',
                'seguiformulario.UD',
                'seguiformulario.FDEL',
                'seguiformulario.TOTAL',
                'seguiformulario.porcentaje',
                'seguiformulario.tipoencuesta',
                DB::raw('COUNT(DISTINCT seguipreguntas.ID) as total_preguntas'),
                DB::raw('COUNT(DISTINCT seguiencuesta.ID) as total_encuestas')
            )
                // 🔹 Cambiado a LEFT JOIN para incluir formularios sin preguntas o encuestas
                ->leftJoin('seguipreguntas', 'seguipreguntas.IDFORMULARIO', '=', 'seguiformulario.ID')
                ->leftJoin('seguiencuesta', 'seguiencuesta.idformulario', '=', 'seguiformulario.ID')
                ->groupBy(
                    'seguiformulario.ID',
                    'seguiformulario.NOMBRE',
                    'seguiformulario.ACTIVO',
                    'seguiformulario.UP',
                    'seguiformulario.FINS',
                    'seguiformulario.UD',
                    'seguiformulario.FDEL',
                    'seguiformulario.TOTAL',
                    'seguiformulario.porcentaje',
                    'seguiformulario.tipoencuesta'
                )
                ->orderBy('seguiformulario.ID', 'desc'); // 🔹 Orden opcional para mostrar los más recientes primero

            // Si el usuario pide todos los datos (sin paginación)
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get();

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

            // 🔹 Paginación (por defecto 20)
            $data = $query->paginate(20);

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
        $res = SeguiFormulario::create($inputs);
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
        $data =  SeguiFormulario::select(
            'seguiformulario.ID',
            'seguiformulario.NOMBRE',
            'seguiformulario.ACTIVO',
            'seguiformulario.UP',
            'seguiformulario.FINS',
            'seguiformulario.UD',
            'seguiformulario.FDEL',
            'seguiformulario.TOTAL',
            'seguiformulario.porcentaje',
            'seguiformulario.tipoencuesta',
            DB::raw('COUNT(seguipreguntas.ID) as total_preguntas'), // 🔹
            DB::raw('COUNT(seguiencuesta.ID) as total_encuestas'), // 🔹
        )
            ->leftJoin('seguipreguntas', 'seguipreguntas.IDFORMULARIO', '=', 'seguiformulario.ID')
            ->leftJoin('seguiencuesta', 'seguiencuesta.idformulario', '=', 'seguiformulario.ID')
            ->groupBy(
                'seguiformulario.ID',
                'seguiformulario.NOMBRE',
                'seguiformulario.ACTIVO',
                'seguiformulario.UP',
                'seguiformulario.FINS',
                'seguiformulario.UD',
                'seguiformulario.FDEL',
                'seguiformulario.TOTAL',
                'seguiformulario.porcentaje',
                'seguiformulario.tipoencuesta',
            )
            ->where('seguiformulario.ID', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
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
    public function ver_formulario(string $id)
    {
        $data =  SeguiFormulario::select(
            'seguiformulario.ID',
            'seguiformulario.NOMBRE',
            'seguiformulario.ACTIVO',
            'seguiformulario.UP',
            'seguiformulario.FINS',
            'seguiformulario.UD',
            'seguiformulario.FDEL',
            'seguiformulario.TOTAL',
            'seguiformulario.porcentaje',
            'seguiformulario.tipoencuesta',
            DB::raw('COUNT(seguipreguntas.ID) as total_preguntas'), // 🔹
            DB::raw('COUNT(seguiencuesta.ID) as total_encuestas'), // 🔹
        )
            ->join('seguipreguntas', 'seguipreguntas.IDFORMULARIO', '=', 'seguiformulario.ID')
            ->leftJoin('seguiencuesta', 'seguiencuesta.idformulario', '=', 'seguiformulario.ID')
            ->groupBy(
                'seguiformulario.ID',
                'seguiformulario.NOMBRE',
                'seguiformulario.ACTIVO',
                'seguiformulario.UP',
                'seguiformulario.FINS',
                'seguiformulario.UD',
                'seguiformulario.FDEL',
                'seguiformulario.TOTAL',
                'seguiformulario.porcentaje',
                'seguiformulario.tipoencuesta',
            )
            ->where('seguiformulario.ID', $id)
            ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
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
        $res = SeguiFormulario::find($id);
        if (isset($res)) {
            $res->NOMBRE = $request->NOMBRE;
            $res->ACTIVO = $request->ACTIVO;
            $res->UP = $request->UP;
            $res->FINS = $request->FINS;
            $res->UD = $request->UD;
            $res->FDEL = $request->FDEL;
            $res->TOTAL = $request->TOTAL;
            $res->porcentaje = $request->porcentaje;
            $res->tipoencuesta = $request->tipoencuesta;

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
                'mensaje' => "El formulario con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = SeguiFormulario::find($id);
        if (isset($res)) {
            $res->ACTIVO = 0;
            $res->save();

            return response()->json([
                'data' => $res,
                'mensaje' => "Formulario inhabilitado con éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "Formulario con id: $id no Existe",
            ]);
        }
    }
    public function habilitar(string $id)
    {
        $res = SeguiFormulario::find($id);
        if (isset($res)) {
            $res->ACTIVO = 1;
            $res->save();

            return response()->json([
                'data' => $res,
                'mensaje' => "Formulario habilitada con éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "Formulario con id: $id no Existe",
            ]);
        }
    }
}
