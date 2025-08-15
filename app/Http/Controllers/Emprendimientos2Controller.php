<?php

namespace App\Http\Controllers;
use App\Models\Emprendimientos;
use Illuminate\Http\Request;

class Emprendimientos2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = Emprendimientos::select('be_emprendimientos.*')
        ->where('be_emprendimientos.id', $id)
        ->get();
        if ($res) {
            return response()->json([
                'data' => $res,
                'mensaje' => "Encontrado con Éxito!!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "La Oferta de Empleo no Existe",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $res = Emprendimientos::find($id);

        if ($res) {
            $res->update($request->all());

            return response()->json([
                'data' => $res,
                'mensaje' => "Emprendimiento actualizado con éxito!",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El emprendimiento con id: $id no existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Emprendimientos::find($id);
        if(isset($res)){
            $elim = Emprendimientos::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Oferta_Empleo no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Oferta_Empleo con id: $id no Existe",
            ]);
        }
    }
}
