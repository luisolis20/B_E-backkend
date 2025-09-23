<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarEmprendimiento;
class EmailEnviarEmprenController extends Controller
{
    //
    //public function sendEmail(Request $request)
    public function enviarrevisionEmprendimiento(Request $request)
        {
        
            $correoUsuario = $request->input('email');
            $nombreUsuario = $request->input('firts_name');
            $nombreEmprendimiento = $request->input('nombreEmprendimiento');

            try {
                // Envía el correo electrónico de aceptación de postulación al usuario
                Mail::send(new EnviarEmprendimiento($nombreUsuario, $nombreEmprendimiento, $correoUsuario));
    
                return response()->json(['nombreUsuario'=>$nombreUsuario,
                    'nombreEmprendimiento'=>$nombreEmprendimiento,
                    'correoUsuario'=>$correoUsuario,
                    'message' => 'Correo de aceptación de postulación enviado con éxito al usuario'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al enviar el correo electrónico de aceptación de postulación: ' . $e->getMessage()], 500);
            }

        }
}
