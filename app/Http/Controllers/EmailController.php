<?php

namespace App\Http\Controllers;

use App\Mail\EnviarCorreo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail;
use App\Mail\AceptacionPostulacion;
use App\Models\User;
class EmailController extends Controller
{
    //
    //public function sendEmail(Request $request)
    public function enviarAceptacionPostulacion(Request $request)
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

            try {
                // Envía el correo electrónico de aceptación de postulación al usuario
                Mail::to($correoDestino)->send(new AceptacionPostulacion($nombreUsuario));
    
                return response()->json(['message' => 'Correo de aceptación de postulación enviado con éxito al usuario'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al enviar el correo electrónico de aceptación de postulación: ' . $e->getMessage()], 500);
            }

        }
}
