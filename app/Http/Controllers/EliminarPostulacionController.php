<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulacion;
use App\Models\User;
class EliminarPostulacionController extends Controller
{
    public function eliminarPostulacion($id) {
        try {
            // Buscar la postulación por su ID
            $postulacion = Postulacion::find($id);

            // Verificar si la postulación existe
            if (!$postulacion) {
                return response()->json(['error' => 'Postulación no encontrada'], 404);
            }

            // Eliminar la postulación de la base de datos
            $postulacion->delete();

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'Postulación eliminada con éxito'], 200);
        } catch (\Exception $e) {
            // Si ocurre un error, retornar un mensaje de error
            return response()->json(['error' => 'Error al eliminar la postulación: ' . $e->getMessage()], 500);
        }
    }
}
