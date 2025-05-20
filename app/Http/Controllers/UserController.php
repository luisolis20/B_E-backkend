<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs["password"] = Hash::make(trim($request->password)); 
        $res = User::create($inputs);
        return response()->json([
            'data'=>$res,
            'mensaje'=>"Agregado con Éxito!!",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = User::find($id);
        if (isset($res)) {
            // Verificar si la imagen existe y codificarla en base64
            $res->imagen = $res->imagen ? base64_encode($res->imagen) : null;
    
            return response()->json([
                'data' => $res,
                'mensaje' => "Encontrado con Éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El Usuario con id: $id no Existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = User::find($id);
        if(isset($res)){
            $res->name = $request->firts_name;
            $res->email = $request->email;
            $res->password = Hash::make($request->password);
            $res->role = $request->role;
            $res->estado = $request->estado;
            if($res->save()){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Actualizado con Éxito!!",
                ]);
            }
            else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>"Error al Actualizar",
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El Usuario con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = User::find($id);
        if(isset($res)){
            $elim = User::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"El usuario no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"El usuario con id: $id no Existe",
            ]);
        }
    }
    /*
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'error' => true,
                'mensaje' => 'Credenciales inválidas',
            ]);
        }

        $token = $user->createToken('customToken')->accessToken;

        return response()->json([
            'mensaje' => 'Autenticación exitosa',
            'token' => $token,
            'rol' => $user->rol,
            'email' => $user->email,
            'id' => $user->id,
        ]);
    }*/
}
