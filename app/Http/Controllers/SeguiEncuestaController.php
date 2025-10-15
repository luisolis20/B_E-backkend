<?php

namespace App\Http\Controllers;

use App\Models\SeguiEncuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SeguiEncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = SeguiEncuesta::select(
                'seguiencuesta.*',

            );

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
        $res = SeguiEncuesta::create($inputs);
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
        $data =  SeguiEncuesta::select(
            'seguiencuesta.*',
        )
            ->where('seguiencuesta.ID', $id)
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
    public function verificar_usuario_encuesta($cedula)
    {
        try {
            // Buscar usuario por cédula, ordenando por la fecha más reciente
            $usuario = SeguiEncuesta::where('cedula_estudiante', $cedula)
                ->orderByDesc('fecha')
                ->first();

            // Caso 1: Usuario nunca ha llenado la encuesta
            if (!$usuario) {
                return response()->json([
                    'mensaje' => 'El usuario no ha respondido la encuesta.'
                ], 404);
            }

            // Convertir fecha (guardada como VARCHAR) a formato Carbon
            $fechaRegistro = \Carbon\Carbon::parse($usuario->fecha);
            $fechaActual = \Carbon\Carbon::now();
            $diferenciaDias = $fechaRegistro->diffInDays($fechaActual);

            // Convertir campos a UTF-8 válido
            $atributos = $usuario->getAttributes();
            foreach ($atributos as $key => $value) {
                if (is_string($value)) {
                    $atributos[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }

            // Caso 2: Han pasado más de 180 días (≈6 meses)
            if ($diferenciaDias > 180) {
                return response()->json([
                    'data' => $atributos,
                    'mensaje' => 'Debe volver a llenar la encuesta.'
                ]);
            }

            // Caso 3: Exactamente 180 días
            if ($diferenciaDias === 180) {
                return response()->json([
                    'data' => $atributos
                ]);
            }

            // Caso 4: Menos de 180 días
            return response()->json([
                'data' => $atributos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al verificar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = SeguiEncuesta::find($id);
        if (isset($res)) {
            $res->TIPORESPUESTA = $request->TIPORESPUESTA;
            $res->IDPREGUNTA = $request->IDPREGUNTA;
            $res->UP = $request->UP;
            $res->FINS = $request->FINS;
            $res->UD = $request->UD;
            $res->FDEL = $request->FDEL;
            $res->valor = $request->valor;

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
        $res = SeguiEncuesta::find($id);
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
        $res = SeguiEncuesta::find($id);
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
