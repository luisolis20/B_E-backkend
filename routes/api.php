<?php

use App\Http\Controllers\ConstOfertController;
use App\Http\Controllers\ConstEmprenidimientosController;//Emprendimiento
use App\Http\Controllers\ConstPostuController;
use App\Http\Controllers\ConstEmprendimientoPostuController;//Emprendimiento
use App\Http\Controllers\ConstPostUsersController;
use App\Http\Controllers\ConstEmprendimientoPostUsersController;//Emprendimiento
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Oferta_EmpleoController;
use App\Http\Controllers\EmprendimientosController;//Emprendimiento
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\InteraccionesEmprendimientosController;// Interacciones Emprendimientos
use App\Http\Controllers\Postulacion2Controller;
use App\Http\Controllers\InteraccionesEmprendimientos2Controller;// Interacciones Emprendimientos
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EliminarPostulacionController;
use App\Http\Controllers\InformacionPersonalController;
use App\Http\Controllers\RegistroTituloController;
use App\Http\Controllers\ConstOfertasNOPOST;
use App\Http\Controllers\ConstEmprendimientosNOPOST;//Emprendimiento
use App\Http\Controllers\ConstEstadoPOSTController;
use App\Http\Controllers\ConstEstadoEmprendimientoPOSTController;//Emprendimiento
use App\Http\Controllers\ConstEstadoPOST2Controller;
use App\Http\Controllers\ConstEstadoEMprendimientoPOST2Controller;//Emprendimiento
use App\Http\Controllers\ConstPostUsersEstadoController;
use App\Http\Controllers\ConstEmprendimientoPostUsersEstadoController;//Emprendimiento
use App\Http\Controllers\ConstPostUsersEstado2Controller;
use App\Http\Controllers\ConstEmprendimientoPostUsersEstado2Controller;//Emprendimiento
use App\Http\Controllers\Oferta_Empleo2Controller;
use App\Http\Controllers\Emprendimientos2Controller;
use App\Http\Controllers\EnviarComentarioController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('b_e')->group(function () {

    Route::apiResource("vin/empresas",EmpresaController::class);
    Route::apiResource("vin/users",UserController::class);
    Route::apiResource("vin/oferta__empleos",Oferta_EmpleoController::class);
    Route::apiResource("vin/emprendimientos",EmprendimientosController::class);//Emprendimiento
    Route::apiResource("vin/oferta__empleos2",Oferta_Empleo2Controller::class);
    Route::apiResource("vin/emprendimientos2",Emprendimientos2Controller::class);//Emprendimiento
    Route::apiResource("vin/postulacions",PostulacionController::class);
    Route::apiResource("vin/interaccionempren",InteraccionesEmprendimientosController::class);// Interacciones Emprendimientos
    Route::apiResource("vin/postulacions2",Postulacion2Controller::class);
    Route::apiResource("vin/postulacions2empre",InteraccionesEmprendimientos2Controller::class);// Interacciones Emprendimientos
    Route::post('vin/enviar-comentario', [EnviarComentarioController::class, 'enviarComentario']);
    Route::post('vin/login', [InformacionPersonalController::class, 'login']);
    Route::apiResource('vin/informacionpersonal', InformacionPersonalController::class);
    Route::apiResource('vin/registrotitulos', RegistroTituloController::class);
    Route::apiResource('vin/consultaredir',ConsultaController::class);
    Route::apiResource('vin/consultapost',ConstPostuController::class);
    Route::apiResource('vin/consultapostempr',ConstEmprendimientoPostuController::class);//Emprendimiento 
    Route::apiResource('vin/consultapostuser',ConstPostUsersController::class);
    Route::apiResource('vin/consultapostuserempr',ConstEmprendimientoPostUsersController::class);
    Route::apiResource('vin/consultapostuserestado',ConstPostUsersEstadoController::class);
    Route::apiResource('vin/consultapostuserestadoempr',ConstEmprendimientoPostUsersEstadoController::class);//Emprendimiento
    Route::apiResource('vin/consultapostuserestado2',ConstPostUsersEstado2Controller::class);
    Route::apiResource('vin/consultapostuserestado2empr',ConstEmprendimientoPostUsersEstado2Controller::class);
    Route::apiResource('vin/consultaofert',ConstOfertController::class);
    Route::apiResource('vin/consultaempr',ConstEmprenidimientosController::class);//Emprendimiento
    Route::apiResource('vin/consultanopostofert',ConstOfertasNOPOST::class);
    Route::apiResource('vin/consultanopostempre',ConstEmprendimientosNOPOST::class);//Emprendimiento
    Route::apiResource('vin/estadopostuser',ConstEstadoPOSTController::class);
    Route::apiResource('vin/estadopostuserempr',ConstEstadoEmprendimientoPOSTController::class);//Emprendimiento
    Route::apiResource('vin/estadopostuser2',ConstEstadoPOST2Controller::class);
    Route::apiResource('vin/estadopostuser2empr',ConstEstadoEMprendimientoPOST2Controller::class);
    Route::post('vin/enviar-correo', [CorreoController::class, 'enviarCorreo']);
    Route::post('vin/enviar-aceptacion-postulacion', [EmailController::class, 'enviarAceptacionPostulacion']);
    Route::delete('vin/eliminar-postulacion/{id}', [EliminarPostulacionController::class, 'eliminarPostulacion']);

    //Login

    
    Route::post('login2', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});