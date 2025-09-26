<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RechazoEmprendimiento;
class EmailRechazarEmprendimientoController extends Controller
{
    //
    //public function sendEmail(Request $request)
    public function enviarrechazoEmprendimiento(Request $request)
        {
        
            $correoDestino = $request->input('email');
            $nombreUsuario = $request->input('firts_name');
            $nombreEmprendimiento = $request->input('company_name');

            try {
                // Envía el correo electrónico de aceptación de postulación al usuario
                Mail::to($correoDestino)->send(new RechazoEmprendimiento($nombreUsuario, $nombreEmprendimiento));
    
                return response()->json(['nombreUsuario'=>$nombreUsuario,
                    'nombreEmprendimiento'=>$nombreEmprendimiento,
                    'message' => 'Correo de aceptación de postulación enviado con éxito al usuario'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al enviar el correo electrónico de aceptación de postulación: ' . $e->getMessage()], 500);
            }

        }
}
