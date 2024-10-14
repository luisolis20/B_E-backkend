<?php

namespace App\Http\Controllers;
use App\Models\RegistroTitulos;
use Illuminate\Http\Request;

class RegistroTituloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RegistroTitulos::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $res = RegistroTitulos::create($inputs);
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
        return RegistroTitulos::select('registrotitulos.*')
        ->where('registrotitulos.ciinfper', $id)
        ->get();
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
       
    }
}
