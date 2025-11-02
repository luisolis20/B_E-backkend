<?php

use App\Http\Controllers\ConstOfertController;
use App\Http\Controllers\ConstOfertEmprenidimientosController;//Emprendimiento
use App\Http\Controllers\ConstOfertEmprenidimientos2Controller;//Emprendimiento
use App\Http\Controllers\ConstPostuController;
use App\Http\Controllers\ConstEmprendimientoPostuController;//Emprendimiento
use App\Http\Controllers\ConstPostUsersController;
use App\Http\Controllers\ConstEmprendimientoPostUsersController;//Emprendimiento
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ConsultaControllerEmprendimiento;//Emprendimiento
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmprendimientosEController;//Emprendimiento
use App\Http\Controllers\Oferta_EmpleoController;
use App\Http\Controllers\Oferta_EmprendimientosController;//Emprendimiento
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\PostulacionEmprendimientosController;// Interacciones Emprendimientos
use App\Http\Controllers\Postulacion2Controller;
use App\Http\Controllers\InteraccionesEmprendimientos2Controller;// Interacciones Emprendimientos
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailRechazoController;
use App\Http\Controllers\EmailEnviarEmprenController;
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
use App\Http\Controllers\Oferta_Emprendimientos2Controller;
use App\Http\Controllers\EnviarComentarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformacionPersonalDController;
use App\Http\Controllers\EmailEnviarActualizarEmprenController;
use App\Http\Controllers\EmailAprobarEmprendimientoController;
use App\Http\Controllers\EmailRechazarEmprendimientoController;
use App\Http\Controllers\EmailEnviarOfertaEmprenController;
use App\Http\Controllers\EmailAprobarOfertaEmprendimientoController;
use App\Http\Controllers\EmailRechazarOfertaEmprendimientoController;
use App\Http\Controllers\SeguiFormularioController;
use App\Http\Controllers\SeguiPreguntasController;
use App\Http\Controllers\SeguiTipoRespuestaController;
use App\Http\Controllers\SeguiEncuestaController;
use App\Http\Controllers\SeguiDetalleEncuestaController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\FacultadController;
use App\Http\Controllers\CarreraController;



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

    Route::post('vin/enviar-comentario', [EnviarComentarioController::class, 'enviarComentario']);
    
    //Login
    
    
    Route::post('login2', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::apiResource("vin/empresas",EmpresaController::class);
        Route::apiResource('vin/informacionpersonalD', InformacionPersonalDController::class);
        Route::apiResource("vin/sede",SedeController::class);
        Route::apiResource("vin/facultad",FacultadController::class);
        Route::apiResource("vin/seguiformulario",SeguiFormularioController::class);
        Route::apiResource("vin/seguipreguntas",SeguiPreguntasController::class);
        Route::apiResource("vin/seguiencuesta",SeguiEncuestaController::class);
        Route::apiResource("vin/seguidetalleencuesta",SeguiDetalleEncuestaController::class);
        Route::apiResource("vin/seguitiporespuesta",SeguiTipoRespuestaController::class);
        Route::delete("vin/empresashabi/{id}",[EmpresaController::class, 'habilitar']);
        Route::delete("vin/seguiformulariohabi/{id}",[SeguiFormularioController::class, 'habilitar']);
        Route::get("vin/empresasEM/{id}",[EmpresaController::class, 'ver_empresa']);
        Route::get("vin/carreras/{id}",[CarreraController::class, 'carrerasPorFacultad']);
        Route::get("vin/ver_rep/{id}",[SeguiEncuestaController::class, 'ver_rep']);
        Route::get("vin/ver_respuestas_abiertas/{id}",[SeguiEncuestaController::class, 'ver_respuestas_abiertas']);
        Route::get("vin/verpreg/{id}",[SeguiPreguntasController::class, 'verpreg']);
        Route::get("vin/ver_pregunta_en",[SeguiPreguntasController::class, 'ver_pregunta_en']);
        Route::get("vin/verificar_usuario_encuesta/{cedula}",[SeguiEncuestaController::class, 'verificar_usuario_encuesta']);
        Route::get("vin/seguiformularioEM/{id}",[SeguiFormularioController::class, 'ver_formulario']);
        Route::get("vin/view-emprendimiento/{id}",[EmprendimientosEController::class, 'ver_emprendimiento']);
        Route::apiResource("vin/emprendimientos_E",EmprendimientosEController::class);
        Route::apiResource("vin/users",UserController::class);
        Route::delete("vin/usershabi/{id}",[UserController::class, 'habilitar']);
        Route::apiResource("vin/oferta__empleos",Oferta_EmpleoController::class);
        Route::delete("vin/oferta__empleoshabi/{id}",[Oferta_EmpleoController::class, 'habilitar']);
        Route::apiResource("vin/oferta_empleos_emprendimiento",Oferta_EmprendimientosController::class);//Emprendimiento
        Route::delete("vin/oferta_empleos_emprendimientohabi/{id}",[Oferta_EmprendimientosController::class, 'habilitar']);
        Route::get("vin/view-oferta_empleos_emprendimiento/{id}",[Oferta_EmprendimientosController::class, 'ver_oferta_emprendimiento']);
        Route::apiResource("vin/oferta__empleos2",Oferta_Empleo2Controller::class);
        Route::apiResource("vin/oferta_empleos_emprendimientos2",Oferta_Emprendimientos2Controller::class);//Emprendimiento
        Route::apiResource("vin/postulacions",PostulacionController::class);
        Route::apiResource("vin/postulacionemprendi",PostulacionEmprendimientosController::class);// Interacciones Emprendimientos
        Route::apiResource("vin/postulacions2",Postulacion2Controller::class);
        Route::apiResource("vin/postulacions2empre",InteraccionesEmprendimientos2Controller::class);// Interacciones Emprendimientos
        Route::post('vin/login', [InformacionPersonalController::class, 'login']);
        Route::apiResource('vin/informacionpersonal', InformacionPersonalController::class);
        Route::apiResource('vin/registrotitulos', RegistroTituloController::class);
        Route::get('vin/titulog/{id}', [RegistroTituloController::class, 'titulog']);
        Route::apiResource('vin/consultaredir',ConsultaController::class);
        Route::apiResource('vin/consultarediremp',ConsultaControllerEmprendimiento::class);
        Route::delete('vin/consultaredirempelim/{id}',[ConsultaControllerEmprendimiento::class, 'destroy']);
        Route::delete('vin/consultaredirempelim2/{id}',[ConsultaControllerEmprendimiento::class, 'habilitar']);
        Route::apiResource('vin/consultapost',ConstPostuController::class);
        Route::apiResource('vin/consultapostempr',ConstEmprendimientoPostuController::class);//Emprendimiento 
        Route::apiResource('vin/consultapostuser',ConstPostUsersController::class);
        Route::apiResource('vin/consultapostuserempr',ConstEmprendimientoPostUsersController::class);
        Route::apiResource('vin/consultapostuserestado',ConstPostUsersEstadoController::class);
        Route::apiResource('vin/consultapostuserestadoempr',ConstEmprendimientoPostUsersEstadoController::class);//Emprendimiento
        Route::apiResource('vin/consultapostuserestado2',ConstPostUsersEstado2Controller::class);
        Route::apiResource('vin/consultapostuserestado2empr',ConstEmprendimientoPostUsersEstado2Controller::class);
        Route::apiResource('vin/consultaofert',ConstOfertController::class);
        Route::apiResource('vin/consultaofertempr',ConstOfertEmprenidimientosController::class);//Emprendimiento
        Route::apiResource('vin/consultaofertempr2',ConstOfertEmprenidimientos2Controller::class);//Emprendimiento
        Route::apiResource('vin/consultanopostofert',ConstOfertasNOPOST::class);
        Route::apiResource('vin/consultanopostempre',ConstEmprendimientosNOPOST::class);//Emprendimiento
        Route::apiResource('vin/estadopostuser',ConstEstadoPOSTController::class);
        Route::apiResource('vin/estadopostuserempr',ConstEstadoEmprendimientoPOSTController::class);//Emprendimiento
        Route::apiResource('vin/estadopostuser2',ConstEstadoPOST2Controller::class);
        Route::apiResource('vin/estadopostuser2empr',ConstEstadoEMprendimientoPOST2Controller::class);
        Route::post('vin/enviar-correo', [CorreoController::class, 'enviarCorreo']);
        Route::post('vin/enviar-aceptacion-postulacion', [EmailController::class, 'enviarAceptacionPostulacion']);
        Route::post('vin/enviar-aprobacion-emprendimiento', [EmailAprobarEmprendimientoController::class, 'enviaraprobarEmprendimiento']);
        Route::post('vin/enviar-aprobacion-oferta-emprendimiento', [EmailAprobarOfertaEmprendimientoController::class, 'enviaraprobarofertaEmprendimiento']);
        Route::post('vin/enviar-rechazo-emprendimiento', [EmailRechazarEmprendimientoController::class, 'enviarrechazoEmprendimiento']);
        Route::post('vin/enviar-oferta-rechazo-emprendimiento', [EmailRechazarOfertaEmprendimientoController::class, 'enviarrechazoofertaEmprendimiento']);
        Route::post('vin/enviar-rechazo-postulacion', [EmailRechazoController::class, 'enviarrechazoPostulacion']);
        Route::post('vin/revision-emprendimiento', [EmailEnviarEmprenController::class, 'enviarrevisionEmprendimiento']);
        Route::post('vin/revision-oferta-emprendimiento', [EmailEnviarOfertaEmprenController::class, 'enviarrevisionofertaEmprendimiento']);
        Route::post('vin/revision-actualizacion-emprendimiento', [EmailEnviarActualizarEmprenController::class, 'enviarrevisionacEmprendimiento']);
        Route::delete('vin/eliminar-postulacion/{id}', [EliminarPostulacionController::class, 'eliminarPostulacion']);
    });
});