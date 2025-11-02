<?php

namespace App\Http\Controllers;

use App\Models\informacionpersonal_D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InformacionPersonalDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // 🔹 Controlar el número de registros por página
            $perPage = $request->input('per_page', 20);
            $perPage = min($perPage, 50); // No permitir más de 50 por página

            // 🔹 Consulta optimizada: solo columnas necesarias
            $data = informacionpersonal_D::select('CIInfPer', 'NombInfPer', 'ApellInfPer', 'ApellMatInfPer', 'mailPer', 'TipoInfPer', 'fotografia')
                ->where('StatusPer', 1)
                ->whereNotNull('fotografia')
                ->whereRaw("LENGTH(fotografia) > 0")
                ->paginate($perPage);

            if ($data->isEmpty()) {
                return response()->json(['data' => [], 'message' => 'No se encontraron datos con fotografía'], 200);
            }

            // 🔹 Solo convertir fotografía si el cliente lo solicita
            $withPhotos = $request->boolean('withPhotos', true);

            $data->getCollection()->transform(function ($item) use ($withPhotos) {
                $attributes = $item->getAttributes();

                if ($withPhotos && !empty($attributes['fotografia'])) {
                    $finfo = new \finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->buffer($attributes['fotografia']);
                    $attributes['fotografia'] = [
                        'mime' => $mimeType,
                        'data' => base64_encode($attributes['fotografia']),
                    ];
                } else {
                    // Si no se pide, enviamos solo una bandera
                    unset($attributes['fotografia']);
                    $attributes['hasPhoto'] = true;
                }

                return $attributes;
            });

            return response()->json([
                'data' => $data->items(),
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'last_page' => $data->lastPage(),
                ]
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error interno del servidor: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Aplica paginación al resultado del filtro
        $data = informacionpersonal_D::select('informacionpersonal_d.*')
            ->where('informacionpersonal_d.CIInfPer', $id)
            ->paginate(20);
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir los campos a UTF-8 válido para cada página
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
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
