<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RechazoOFertaEmprendimiento;
class EmailRechazarOfertaEmprendimientoController extends Controller
{
    //
    //public function sendEmail(Request $request)
    public function enviarrechazoofertaEmprendimiento(Request $request)
        {
        
            $correoDestino = $request->input('email');
            $nombreUsuario = $request->input('firts_name');
            $nombreOferta = $request->input('nombreOferta');

            try {
                // Envía el correo electrónico de aceptación de postulación al usuario
                Mail::to($correoDestino)->send(new RechazoOFertaEmprendimiento($nombreUsuario, $nombreOferta));
    
                return response()->json(['nombreUsuario'=>$nombreUsuario,
                    'nombreOferta'=>$nombreOferta,
                    'message' => 'Correo de aceptación de postulación enviado con éxito al usuario'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al enviar el correo electrónico de aceptación de postulación: ' . $e->getMessage()], 500);
            }

        }
}
