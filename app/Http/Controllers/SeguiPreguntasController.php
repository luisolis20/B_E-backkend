<?php

namespace App\Http\Controllers;

use App\Models\SeguiPreguntas;
use App\Models\SeguiTipoRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeguiPreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Parámetro del formulario
            $formularioId = $request->query('formulario_id');

            // SQL de tu consulta EXACTA
            $sql = "
            SELECT 
                seguipreguntas.ID,
                seguipreguntas.PREGUNTA,
                seguipreguntas.IDFORMULARIO,
                seguipreguntas.UP,
                seguipreguntas.FINS,
                seguipreguntas.UD,
                seguipreguntas.FDEL,
                seguipreguntas.tipo,
                seguiformulario.ID AS id_formulario,
                seguiformulario.NOMBRE,
                COUNT(DISTINCT seguitiporespuesta.ID) AS total_tipos_respuesta
            FROM seguipreguntas
            INNER JOIN seguiformulario 
                ON seguiformulario.ID = seguipreguntas.IDFORMULARIO
            LEFT JOIN seguitiporespuesta 
                ON seguitiporespuesta.IDPREGUNTA = seguipreguntas.ID
            WHERE seguipreguntas.IDFORMULARIO = ?
            GROUP BY 
                seguipreguntas.ID,
                seguipreguntas.PREGUNTA,
                seguipreguntas.IDFORMULARIO,
                seguipreguntas.UP,
                seguipreguntas.FINS,
                seguipreguntas.UD,
                seguipreguntas.FDEL,
                seguipreguntas.tipo,
                seguiformulario.ID,
                seguiformulario.NOMBRE";

            // Si el usuario pide todo
            if ($request->query('all') === 'true') {
                $data = DB::select($sql, [$formularioId]);

                // Convertir a UTF-8
                $data = collect($data)->map(function ($item) {
                    foreach ($item as $key => $value) {
                        if (is_string($value)) {
                            $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $item;
                });

                return response()->json(['data' => $data]);
            }

            // PAGINACIÓN MANUAL
            $page = $request->query('page', 1);
            $perPage = 20;

            $allData = collect(DB::select($sql, [$formularioId]));

            // Procesar UTF-8
            $allData = $allData->map(function ($item) {
                foreach ($item as $key => $value) {
                    if (is_string($value)) {
                        $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $item;
            });

            $total = $allData->count();
            $items = $allData->slice(($page - 1) * $perPage, $perPage)->values();

            return response()->json([
                'data' => $items,
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => ceil($total / $perPage),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al ejecutar consulta SQL: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $inputs = $request->input();
        $res = SeguiPreguntas::create($inputs);
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
        $data =  SeguiPreguntas::select(
            'seguipreguntas.ID',
            'seguipreguntas.PREGUNTA',
            'seguipreguntas.IDFORMULARIO',
            'seguipreguntas.UP',
            'seguipreguntas.FINS',
            'seguipreguntas.UD',
            'seguipreguntas.FDEL',
            'seguipreguntas.tipo',
            'seguiformulario.ID as id_formulario',
            'seguiformulario.NOMBRE',
            'seguitiporespuesta.TIPORESPUESTA',
        )
            ->join('seguiformulario', 'seguiformulario.ID', '=', 'seguipreguntas.IDFORMULARIO')
            ->leftJoin('seguitiporespuesta', 'seguitiporespuesta.IDPREGUNTA', '=', 'seguipreguntas.ID')
            ->where('seguipreguntas.ID', $id)
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
    public function verpreg(string $id)
    {
        $data =  SeguiPreguntas::select(
            'seguipreguntas.*',
        )
            ->where('seguipreguntas.ID', $id)
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
    public function ver_pregunta_en()
    {
        try {
            // Trae todas las preguntas del formulario (aunque no tengan opciones)
            $preguntas = SeguiPreguntas::select(
                'seguipreguntas.ID',
                'seguipreguntas.PREGUNTA',
                'seguipreguntas.IDFORMULARIO',
                'seguipreguntas.UP',
                'seguipreguntas.FINS',
                'seguipreguntas.UD',
                'seguipreguntas.FDEL',
                'seguipreguntas.tipo',
                'seguiformulario.NOMBRE',
                'seguiencuesta.ID as id_encuesta',
            )
                ->join('seguiformulario', 'seguiformulario.ID', '=', 'seguipreguntas.IDFORMULARIO')
                ->leftJoin('seguiencuesta', 'seguiencuesta.idformulario', '=', 'seguiformulario.ID')
                ->where('seguiformulario.ACTIVO', 1)
                ->where('seguiformulario.tipoencuesta', 'Graduados')
                ->get();

            if ($preguntas->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No se encontraron datos'
                ], 200);
            }

            // Traer todas las opciones (tipo de respuesta)
            $respuestas = SeguiTipoRespuesta::select(
                'seguitiporespuesta.IDPREGUNTA',
                'seguitiporespuesta.ID as id_tipo_respuesta',
                'seguitiporespuesta.TIPORESPUESTA'
            )
                ->whereIn('seguitiporespuesta.IDPREGUNTA', $preguntas->pluck('ID'))
                ->get()
                ->groupBy('IDPREGUNTA');

            // Combinar preguntas con sus respuestas
            $agrupado = $preguntas->map(function ($pregunta) use ($respuestas) {
                $opciones = $respuestas->get($pregunta->ID, collect());

                // Si no tiene opciones (pregunta abierta)
                if ($opciones->isEmpty()) {
                    return [
                        'id' => $pregunta->ID,
                        'pregunta' => $pregunta->PREGUNTA,
                        'tipo' => $pregunta->tipo,
                        'nombre_formulario' => $pregunta->NOMBRE,
                        'IDFORMULARIO' => $pregunta->IDFORMULARIO,
                        'id_encuesta' => $pregunta->id_encuesta,
                        'respuestas' => [
                            [
                                'id_respuesta' => 0,
                                'texto' => '' // vacío porque será textarea
                            ]
                        ]
                    ];
                }

                // Si tiene opciones (pregunta cerrada)
                return [
                    'id' => $pregunta->ID,
                    'pregunta' => $pregunta->PREGUNTA,
                    'tipo' => $pregunta->tipo,
                    'nombre_formulario' => $pregunta->NOMBRE,
                    'IDFORMULARIO' => $pregunta->IDFORMULARIO,
                    'id_encuesta' => $pregunta->id_encuesta,
                    'respuestas' => $opciones->map(function ($item) {
                        return [
                            'id_respuesta' => $item->id_tipo_respuesta,
                            'texto' => $item->TIPORESPUESTA
                        ];
                    })->values()
                ];
            });

            return response()->json(['data' => $agrupado]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las preguntas: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = SeguiPreguntas::find($id);
        if (isset($res)) {
            $res->PREGUNTA = $request->PREGUNTA;
            $res->IDFORMULARIO = $request->IDFORMULARIO;
            $res->UP = $request->UP;
            $res->FINS = $request->FINS;
            $res->UD = $request->UD;
            $res->FDEL = $request->FDEL;
            $res->tipo = $request->tipo;

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
        $res = SeguiPreguntas::find($id);
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
        $res = SeguiPreguntas::find($id);
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
