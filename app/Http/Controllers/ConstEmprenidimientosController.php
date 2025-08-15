<?php

namespace App\Http\Controllers;

use App\Models\Emprendimientos;
use Illuminate\Http\Request;

class ConstEmprenidimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Emprendimientos::select('be_emprendimientos.id',
            'be_emprendimientos.CIInfPer',
            'be_emprendimientos.nombre_emprendimiento',
            'be_emprendimientos.descripcion',
            'be_emprendimientos.tiempo_emprendimiento',
            'be_emprendimientos.horarios_atencion',
            'be_emprendimientos.direccion',
            'be_emprendimientos.fecha_caducidad_oferta_emprend',
            'be_emprendimientos.categoria',
            'be_emprendimientos.telefono_contacto',
            'be_emprendimientos.email_contacto',
            'be_emprendimientos.sitio_web',
            'be_emprendimientos.redes_sociales',
            'informacionpersonal.nombres',
            'informacionpersonal.apellidos'
        )
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = Emprendimientos::select('be_emprendimientos.id',
            'be_emprendimientos.CIInfPer',
            'be_emprendimientos.nombre_emprendimiento',
            'be_emprendimientos.descripcion',
            'be_emprendimientos.tiempo_emprendimiento',
            'be_emprendimientos.horarios_atencion',
            'be_emprendimientos.direccion',
            'be_emprendimientos.fecha_caducidad_oferta_emprend',
            'be_emprendimientos.categoria',
            'be_emprendimientos.telefono_contacto',
            'be_emprendimientos.email_contacto',
            'be_emprendimientos.sitio_web',
            'be_emprendimientos.redes_sociales',
            'informacionpersonal.nombres',
            'informacionpersonal.apellidos'
        )
        ->join('informacionpersonal', 'informacionpersonal.CIInfPer', '=', 'be_emprendimientos.CIInfPer')
        ->where('be_emprendimientos.id', $id)
        ->first();

        if ($res) {
            return response()->json([
                'data' => $res,
                'mensaje' => "Emprendimiento encontrado con éxito",
            ]);
        } else {
            return response()->json([
                'error' => true,
                'mensaje' => "El emprendimiento no existe",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
