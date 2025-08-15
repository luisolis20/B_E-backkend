<?php

namespace App\Http\Controllers;
use App\Models\InteraccionesEmprendimiento;
use Illuminate\Http\Request;

class InteraccionesEmprendimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = InteraccionesEmprendimiento::select(
                'be_interacciones_emprendimientos.id',
                'informacionpersonal.CIInfPer',
                'informacionpersonal.ApellInfPer',
                'informacionpersonal.ApellMatInfPer',
                'informacionpersonal.NombInfPer',
                'informacionpersonal.mailPer',
                'be_emprendimientos.nombre_emprendimiento',
                'be_emprendimientos.descripcion',
                'be_emprendimientos.categoria',
                'be_interacciones_emprendimientos.created_at'
            )
            ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_interacciones_emprendimientos.emprendimiento_id')
            ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_interacciones_emprendimientos.CIInfPer');

            // Si se solicita todo sin paginar
            if ($request->has('all') && $request->all === 'true') {
                $data = $query->get()->map(function ($item) {
                    foreach ($item->getAttributes() as $key => $value) {
                        if (is_string($value)) {
                            $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    return $item;
                });
                return response()->json(['data' => $data]);
            }

            // Paginación por defecto
            $data = $query->paginate(20);

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No se encontraron interacciones'], 404);
            }

            $data->getCollection()->transform(function ($item) {
                foreach ($item->getAttributes() as $key => $value) {
                    if (is_string($value)) {
                        $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    }
                }
                return $item;
            });

            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $res = InteraccionesEmprendimiento::create($inputs);
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
        $data = InteraccionesEmprendimiento::select(
            'be_interacciones_emprendimientos.id',
            'informacionpersonal.CIInfPer',
            'informacionpersonal.ApellInfPer',
            'informacionpersonal.ApellMatInfPer',
            'informacionpersonal.NombInfPer',
            'informacionpersonal.mailPer',
            'be_emprendimientos.nombre_emprendimiento',
            'be_emprendimientos.descripcion',
            'be_emprendimientos.categoria',
            'be_interacciones_emprendimientos.created_at'
        )
        ->join('be_emprendimientos', 'be_emprendimientos.id', '=', 'be_interacciones_emprendimientos.emprendimiento_id')
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_interacciones_emprendimientos.CIInfPer')
        ->where('be_emprendimientos.id', $id)
        ->paginate(20);

        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron interacciones para este emprendimiento'], 404);
        }

        $data->getCollection()->transform(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (is_string($value)) {
                    $item->$key = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
            return $item;
        });

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
            'last_page' => $data->lastPage(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
       
        $res = InteraccionesEmprendimiento::find($id);
        if(isset($res)){
            $res->CIInfPer = $request->CIInfPer;
            $res->emprendimiento_id = $request->emprendimiento_id;
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
                'mensaje'=>"La Postulación de Empleo con id: $id no Existe",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = InteraccionesEmprendimiento::find($id);
        if(isset($res)){
            $elim = InteraccionesEmprendimiento::destroy($id);
            if($elim){
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"Eliminado con Éxito!!",
                ]);
            }else{
                return response()->json([
                    'data'=>$res,
                    'mensaje'=>"La Interacción no existe (puede que ya la haya eliminado)",
                ]);
            }
           
           
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"La Interacción con id: $id no Existe",
            ]);
        }
    }
}
