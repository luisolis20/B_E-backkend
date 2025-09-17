<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RechazoPostulacion;
class EmailRechazoController extends Controller
{
    //
    //public function sendEmail(Request $request)
    public function enviarrechazoPostulacion(Request $request)
        {
        
            //$data = $request->validate([
            //   'email' => 'required|email',
            //    'name' => 'required',
        //  ]);

        //   Mail::to($data['email'])->send(new EnviarCorreo($data['name']));

        //   return response()->json(['message' => 'Email sent successfully']);
            /*
           // $userId = $request->input('user_id');
            $user = User::findOrFail($userId);*/
            $correoDestino = $request->input('email');
            $nombreUsuario = $request->input('firts_name');
            $nombreEmpresa = $request->input('company_name');
            $nombreOferta = $request->input('job_offer');

            try {
                // Envía el correo electrónico de aceptación de postulación al usuario
                Mail::to($correoDestino)->send(new RechazoPostulacion($nombreUsuario, $nombreEmpresa, $nombreOferta));
    
                return response()->json(['nombreUsuario'=>$nombreUsuario,
                    'nombreEmpresa'=>$nombreEmpresa,
                    'nombreOferta'=>$nombreOferta,
                    'message' => 'Correo de aceptación de postulación enviado con éxito al usuario'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al enviar el correo electrónico de aceptación de postulación: ' . $e->getMessage()], 500);
            }

        }
}
