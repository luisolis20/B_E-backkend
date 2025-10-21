<?php

namespace App\Http\Controllers;
use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Sede::select('sede.*')
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    
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
       
    }
}
