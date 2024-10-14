<?php

namespace App\Http\Controllers;
use App\Models\informacionpersonal;
use App\Models\User;
use App\Models\InformacionPersonald;
use App\Models\RegistroTitulos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InformacionPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = informacionpersonal::all();
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir todos los campos a UTF-8 válido
        $data = $data->map(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (is_string($value)) {
                    $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $attributes;
        });

        // Ahora intenta convertir a JSON
        try {
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al codificar los datos a JSON: ' . $e->getMessage()], 500);
        }
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
       
        
        $inputs["codigo_dactilar"] = md5(trim($request->codigo_dactilar)); 
        $res = informacionpersonal::create($inputs);
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
        $data = informacionpersonal::select('informacionpersonal.*')
        ->where('informacionpersonal.CIInfPer', $id)
        ->get();

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el ID especificado'], 404);
        }

        // Convertir todos los campos a UTF-8 válido
        $data = $data->map(function ($item) {
            $attributes = $item->getAttributes();
            foreach ($attributes as $key => $value) {
                if (is_string($value)) {
                    $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $attributes;
        });

        // Ahora intenta convertir a JSON
        try {
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al codificar los datos a JSON: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $res = informacionpersonal::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->ApellInfPer = $request->ApellInfPer;
            $res->ApellMatInfPer = $request->ApellMatInfPer;
            $res->NombInfPer = $request->NombInfPer;
            $res->NacionalidadPer = $request->NacionalidadPer;
            $res->LugarNacimientoPer = $request->LugarNacimientoPer;
            $res->FechNacimPer = $request->FechNacimPer;
            $res->GeneroPer = $request->GeneroPer;
            $res->CiudadPer = $request->CiudadPer;
            $res->DirecDomicilioPer = $request->DirecDomicilioPer;
            $res->Telf1InfPer = $request->Telf1InfPer;
            $res->mailPer = $request->mailPer;
            $res->fotografia = $request->fotografia;
           
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
                'mensaje'=>" $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function login(Request $request)
    {
        $CIInfPer = $request->input('CIInfPer');
        $codigo_dactilar = $request->input('codigo_dactilar');

        
        $res = informacionpersonal::select('CIInfPer', 'codigo_dactilar', 'ApellInfPer', 'mailPer')
            ->where('CIInfPer', $CIInfPer)
            ->first();

        $res2 = RegistroTitulos::select('registrotitulos.*')
            ->where('ciinfper', $CIInfPer)
            ->first();

        $user = User::select('id', 'last_name', 'email', 'rol', 'estado', 'password')
            ->where('email', $CIInfPer)
            ->first();

        if ($res) {
            if($res2){
                if (md5($codigo_dactilar) !== $res->codigo_dactilar) {
                    return response()->json([
                        'error' => true,
                        'clave' => 'clave error',
                        'mensaje' => 'El usuario es correcto pero hay un error en la clave',
                    ]);
                }
                return response()->json([
                    'mensaje' => 'Autenticación exitosa',
                    'Rol' => 'Estudiante',
                    'Graduado' => 'Si',
                    'CIInfPer' => $res->CIInfPer,
                    'ApellInfPer' => $res->ApellInfPer,
                    'mailPer' => $res->mailPer,
                ]);
            }else{
                return response()->json([
                    'mensaje' => 'El usuario estudiante aun no se ha graduado',
                    'Rol' => 'Estudiante',
                    'Graduado' => 'No',
                    'CIInfPer' => $res->CIInfPer,
                    'ApellInfPer' => $res->ApellInfPer,
                    'mailPer' => $res->mailPer,
                ]);
            }
            
        } elseif ($user) {
            if ($user->estado !== 1) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'El usuario está inhabilitado',
                ]);
            }
            if (!Hash::check($codigo_dactilar, $user->password)) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'El usuario es correcto pero hay un error en la clave',
                ]);
            }

            $token = $user->createToken('customToken')->accessToken;

            return response()->json([
                'mensaje' => 'Autenticación exitosa',
                'token' => $token,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'id' => $user->id,
                'rol' => $user->rol,
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El Usuario : $CIInfPer no Existe",
            ]);
        }
    }

}
