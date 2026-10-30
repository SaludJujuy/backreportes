<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controlador_Empresa;
use App\Http\Controllers\Conrolador_ObraSocial;
use App\Http\Controllers\Conrolador_Permiso;
use App\Http\Controllers\Conrolador_Persona;
use App\Http\Controllers\Conrolador_Region;
use App\Http\Controllers\Conrolador_RelacionLaboral;
use App\Http\Controllers\Controlador_Usuario;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para la gestión de empresas
Route::get('/empresas', [Controlador_Empresa::class, 'listarEmpresas']);
Route::get('/empresas/filtro', [Controlador_Empresa::class, 'listarEmpresasParaFiltro']);
Route::get('/empresas/{id}', [Controlador_Empresa::class, 'obtenerEmpresa']);
Route::post('/empresas', [Controlador_Empresa::class, 'crearEmpresa']);
Route::put('/empresas/{id}', [Controlador_Empresa::class, 'actualizarEmpresa']);
Route::delete('/empresas/{id}', [Controlador_Empresa::class, 'eliminarEmpresa']);

// Rutas para la gestión de obras sociales
Route::get('/obras-sociales', [Conrolador_ObraSocial::class, 'listarObraSocial']);
Route::get('/obras-sociales/filtro', [Conrolador_ObraSocial::class, 'listarObraSocialParaFiltro']);
Route::get('/obras-sociales/{id}', [Conrolador_ObraSocial::class, 'obtenerObraSocial']);
Route::post('/obras-sociales', [Conrolador_ObraSocial::class, 'crearObraSocial']);
Route::put('/obras-sociales/{id}', [Conrolador_ObraSocial::class, 'actualizarObraSocial']);
Route::delete('/obras-sociales/{id}', [Conrolador_ObraSocial::class, 'eliminarObraSocial']);

// Rutas para la gestión de permisos
Route::get('/permisos', [Conrolador_Permiso::class, 'listarPermisos']);
Route::get('/permisos/{id}', [Conrolador_Permiso::class, 'obtenerPermiso']);
Route::post('/permisos', [Conrolador_Permiso::class, 'crearPermiso']);
Route::put('/permisos/{id}', [Conrolador_Permiso::class, 'actualizarPermiso']);
Route::delete('/permisos/{id}', [Conrolador_Permiso::class, 'eliminarPermiso']);

// Rutas para la gestión de personas
Route::get('/personas', [Conrolador_Persona::class, 'listarPersonas']);
Route::get('/personas/{id}', [Conrolador_Persona::class, 'obtenerPersona']);
Route::post('/personas', [Conrolador_Persona::class, 'crearPersona']);
Route::put('/personas/{id}', [Conrolador_Persona::class, 'actualizarPersona']);
Route::delete('/personas/{id}', [Conrolador_Persona::class, 'eliminarPersona']);
Route::post('/personas/importar', [Conrolador_Persona::class, 'importar']);
Route::get('/personas/sexos',[Conrolador_Persona::class,'listarSexos']);
Route::get('/personas/sexo/{sexo}',[Conrolador_Persona::class,'listarPersonasPorSexo']);

// Rutas para la gestión de regiones
Route::get('/regiones', [Conrolador_Region::class, 'listarRegiones']);
Route::get('/regiones/filtro', [Conrolador_Region::class, 'listarRegionesParaFiltro']);
Route::get('/regiones/{id}', [Conrolador_Region::class, 'obtenerRegion']);
Route::post('/regiones', [Conrolador_Region::class, 'crearRegion']);
Route::put('/regiones/{id}', [Conrolador_Region::class, 'actualizarRegion']);
Route::delete('/regiones/{id}', [Conrolador_Region::class, 'eliminarRegion']);

// Rutas para la gestión de relaciones laborales
Route::get('/relaciones-laborales', [Conrolador_RelacionLaboral::class, 'listarRelacionLaboral']);
Route::get('/relaciones-laborales/{id}', [Conrolador_RelacionLaboral::class, 'obtenerRelacionLaboral']);
Route::post('/relaciones-laborales', [Conrolador_RelacionLaboral::class, 'crearRelacionLaboral']);
Route::put('/relaciones-laborales/{id}', [Conrolador_RelacionLaboral::class, 'actualizarRelacionLaboral']);
Route::delete('/relaciones-laborales/{id}', [Conrolador_RelacionLaboral::class, 'eliminarRelacionLaboral']);

// Rutas para la gestión de usuarios
Route::get('/usuarios', [Controlador_Usuario::class, 'listarUsuarios']);
Route::get('/usuarios/{id}', [Controlador_Usuario::class, 'obtenerUsuario']);
Route::post('/usuarios', [Controlador_Usuario::class, 'crearUsuario']);
Route::put('/usuarios/{id}', [Controlador_Usuario::class, 'actualizarUsuario']);
Route::delete('/usuarios/{id}', [Controlador_Usuario::class, 'eliminarUsuario']);
Route::post('/user/login', [Controlador_Usuario::class, 'login']);
Route::post('/user/logout', [Controlador_Usuario::class, 'logout']);
