<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarOfertaEmprendimiento;
class EmailEnviarOfertaEmprenController extends Controller
{
    //
    //public function sendEmail(Request $request)
    public function enviarrevisionofertaEmprendimiento(Request $request)
        {
        
            $correoUsuario = $request->input('email');
            $nombreUsuario = $request->input('firts_name');
            $nombreEmprendimiento = $request->input('nombreEmprendimiento');
            $nombreOferta = $request->input('nombreOferta');

            try {
                // Envía el correo electrónico de aceptación de postulación al usuario
                Mail::send(new EnviarOfertaEmprendimiento($nombreUsuario, $nombreEmprendimiento, $correoUsuario, $nombreOferta));
    
                return response()->json(['nombreUsuario'=>$nombreUsuario,
                    'nombreEmprendimiento'=>$nombreEmprendimiento,
                    'correoUsuario'=>$correoUsuario,
                    'nombreOferta'=>$nombreOferta,
                    'message' => 'Correo de envío de emprendimiento'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al enviar el correo electrónico de revisión de emprendimiento: ' . $e->getMessage()], 500);
            }

        }
}
