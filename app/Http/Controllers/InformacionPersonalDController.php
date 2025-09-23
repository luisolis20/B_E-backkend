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
    public function index()
    {
        try {
            $data = informacionpersonal_D::select('informacionpersonal_d.*')
                ->where('informacionpersonal_d.StatusPer', 1)
                ->whereNotNull('informacionpersonal_d.fotografia')
                ->whereRaw("LENGTH(informacionpersonal_d.fotografia) > 0")
                ->paginate(20);

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron datos con fotografía'], 404);
            }

            //  Convertir los campos
            $data->getCollection()->transform(function ($item) {
                $attributes = $item->getAttributes();

                foreach ($attributes as $key => $value) {
                    if ($key === 'fotografia' && !empty($value)) {
                        // Detectar tipo MIME del BLOB
                        $finfo = new \finfo(FILEINFO_MIME_TYPE);
                        $mimeType = $finfo->buffer($value);

                        // Transformar a objeto con mime + base64
                        $attributes[$key] = [
                            'mime' => $mimeType,
                            'data' => base64_encode($value),
                        ];
                    } elseif (is_string($value) && $key !== 'fotografia') {
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
