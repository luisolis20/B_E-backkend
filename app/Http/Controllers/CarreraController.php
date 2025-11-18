<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /// return response()->json(Carrera::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

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
    public function destroy(string $id) {}
    public function carrerasPorFacultad($idfacultad)
    {
        try {
            // Traer las carreras con StatusCarr = 1
            $carreras = Carrera::where('idfacultad', $idfacultad)
                ->where('StatusCarr', 1)
                ->get();

            // Si no hay resultados
            if ($carreras->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No se encontraron datos'
                ], 200);
            }

            // Respuesta exitosa
            return response()->json([
                'message' => 'Carreras habilitadas encontradas correctamente.',
                'data' => $carreras
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las carreras.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
