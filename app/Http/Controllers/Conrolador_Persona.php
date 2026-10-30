<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\ObraSocial;
use App\Models\Region;
use App\Models\RelacionLaboral;
use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Conrolador_Persona extends Controller
{
    public function listarPersonas()
    {
        $personas = Persona::listarPersonas();
        return response()->json($personas);
    }

    public function obtenerPersona(int $id)
    {
        $persona = Persona::listarPersonaPorId($id);
        if ($persona) {
            return response()->json($persona);
        } else {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
    }

    public function crearPersona(Request $request)
    {
        $data = $request->all();
        $persona = Persona::crearPersona($data);
        return response()->json($persona, 201);
    }

    public function actualizarPersona(Request $request, int $id)
    {
        $data = $request->all();
        $persona = Persona::actualizarPersona($id, $data);
        if ($persona) {
            return response()->json($persona);
        } else {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
    }

    public function eliminarPersona(int $id)
    {
        $eliminado = Persona::eliminarPersona($id);
        if ($eliminado) {
            return response()->json(['message' => 'Persona eliminada correctamente']);
        } else {
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
    }

    public function importar(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR ESTRUCTURA
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [

                'personas' =>
                    'required|array|min:1|max:2000',

                'personas.*.cuil' =>
                    'required|string|max:20',

                'personas.*.dni' =>
                    'required|string|max:20',

                'personas.*.apellido' =>
                    'required|string|max:100',

                'personas.*.nombre' =>
                    'required|string|max:100',

                'personas.*.sexo' =>
                    'nullable|string|max:30',

                'personas.*.fecha_nacimiento' =>
                    'nullable|date_format:Y-m-d',

                'personas.*.domicilio' =>
                    'nullable|string|max:255',

                'personas.*.telefono' =>
                    'nullable|string|max:50',

                'personas.*.celular' =>
                    'nullable|string|max:50',

                'personas.*.email' =>
                    'nullable|email|max:150',

                /*
                |--------------------------------------------------------------------------
                | CAMPOS RELACIONADOS
                |--------------------------------------------------------------------------
                */

                'personas.*.obra_social' =>
                    'required|string|max:150',

                'personas.*.localidad' =>
                    'required|string|max:150',

                'personas.*.relacion_laboral' =>
                    'required|string|max:150',

                'personas.*.empresa' =>
                    'required|string|max:200',
            ]
        );


        if ($validator->fails()) {

            return response()->json(
                [
                    'message' =>
                        'Existen registros con datos incorrectos.',

                    'errors' =>
                        $validator->errors()
                ],
                422
            );
        }


        $personas =
            $request->input('personas');


        $creados = 0;

        $actualizados = 0;

        $obrasSocialesCreadas = 0;

        $localidadesCreadas = 0;

        $relacionesLaboralesCreadas = 0;

        $empresasCreadas = 0;


        try {

            DB::beginTransaction();


            foreach ($personas as $item) {

                /*
                |--------------------------------------------------------------------------
                | NORMALIZAR VALORES
                |--------------------------------------------------------------------------
                */

                $nombreObraSocial =
                    trim($item['obra_social']);

                $nombreLocalidad =
                    trim($item['localidad']);

                $nombreRelacionLaboral =
                    trim($item['relacion_laboral']);

                $nombreEmpresa =
                    trim($item['empresa']);


                /*
                |--------------------------------------------------------------------------
                | OBRA SOCIAL
                |--------------------------------------------------------------------------
                |
                | Asumo que la columna de nombre es "razon_social".
                |
                */

                $obraSocial =
                    ObraSocial::whereRaw(
                        'LOWER(TRIM(razon_social)) = ?',
                        [
                            mb_strtolower(
                                $nombreObraSocial
                            )
                        ]
                    )
                    ->first();


                if (!$obraSocial) {

                    $obraSocial =
                        ObraSocial::create(
                            [
                                'razon_social' =>
                                    $nombreObraSocial
                            ]
                        );

                    $obrasSocialesCreadas++;
                }


                /*
                |--------------------------------------------------------------------------
                | LOCALIDAD
                |--------------------------------------------------------------------------
                |
                | Asumo que localidades tiene una columna "nombre".
                |
                */

                $localidad =
                    Region::whereRaw(
                        'LOWER(TRIM(localidad)) = ?',
                        [
                            mb_strtolower(
                                $nombreLocalidad
                            )
                        ]
                    )
                    ->first();


                if (!$localidad) {

                    $localidad =
                        Region::create(
                            [
                                'localidad' =>
                                    $nombreLocalidad
                            ]
                        );

                    $localidadesCreadas++;
                }


                /*
                |--------------------------------------------------------------------------
                | RELACIÓN LABORAL
                |--------------------------------------------------------------------------
                |
                | Asumo que la columna es "nombre".
                |
                */

                $relacionLaboral =
                    RelacionLaboral::whereRaw(
                        'LOWER(TRIM(nombre)) = ?',
                        [
                            mb_strtolower(
                                $nombreRelacionLaboral
                            )
                        ]
                    )
                    ->first();


                if (!$relacionLaboral) {

                    $relacionLaboral =
                        RelacionLaboral::create(
                            [
                                'nombre' =>
                                    $nombreRelacionLaboral
                            ]
                        );

                    $relacionesLaboralesCreadas++;
                }


                /*
                |--------------------------------------------------------------------------
                | EMPRESA
                |--------------------------------------------------------------------------
                |
                | Asumo que Empresas usa "razon_social".
                |
                */

                $empresa =
                    Empresa::whereRaw(
                        'LOWER(TRIM(razon_social)) = ?',
                        [
                            mb_strtolower(
                                $nombreEmpresa
                            )
                        ]
                    )
                    ->first();


                if (!$empresa) {

                    $empresa =
                        Empresa::create(
                            [
                                'razon_social' =>
                                    $nombreEmpresa
                            ]
                        );

                    $empresasCreadas++;
                }


                /*
                |--------------------------------------------------------------------------
                | FECHA DE NACIMIENTO / EDAD
                |--------------------------------------------------------------------------
                */

                $fechaNacimiento = null;

                $edad = null;


                if (
                    !empty(
                        $item['fecha_nacimiento']
                    )
                ) {

                    $fecha =
                        Carbon::createFromFormat(
                            'Y-m-d',
                            $item['fecha_nacimiento']
                        );


                    $fechaNacimiento =
                        $fecha->format(
                            'Y-m-d'
                        );


                    $edad =
                        $fecha->age;
                }


                /*
                |--------------------------------------------------------------------------
                | DATOS DE LA PERSONA
                |--------------------------------------------------------------------------
                */

                $datosPersona = [

                    'dni' =>
                        trim($item['dni']),

                    'apellido' =>
                        trim($item['apellido']),

                    'nombre' =>
                        trim($item['nombre']),

                    'sexo' =>
                        !empty($item['sexo'])
                            ? trim($item['sexo'])
                            : null,

                    'fecha_nacimiento' =>
                        $fechaNacimiento,

                    'edad' =>
                        $edad,

                    /*
                    |--------------------------------------------------------------------------
                    | CSV: domicilio
                    | DB: direccion
                    |--------------------------------------------------------------------------
                    */

                    'direccion' =>
                        !empty($item['domicilio'])
                            ? trim($item['domicilio'])
                            : null,

                    'telefono' =>
                        !empty($item['telefono'])
                            ? trim($item['telefono'])
                            : null,

                    'celular' =>
                        !empty($item['celular'])
                            ? trim($item['celular'])
                            : null,

                    'email' =>
                        !empty($item['email'])
                            ? trim($item['email'])
                            : null,


                    /*
                    |--------------------------------------------------------------------------
                    | IDS RESUELTOS POR LARAVEL
                    |--------------------------------------------------------------------------
                    */

                    'obra_social_id' =>
                        $obraSocial->id,

                    'localidad_id' =>
                        $localidad->id,

                    'relacion_laboral_id' =>
                        $relacionLaboral->id,

                    'empresa_id' =>
                        $empresa->id,
                ];


                /*
                |--------------------------------------------------------------------------
                | BUSCAR PERSONA POR CUIL
                |--------------------------------------------------------------------------
                */

                $persona =
                    Persona::where(
                        'cuil',
                        trim($item['cuil'])
                    )
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR
                |--------------------------------------------------------------------------
                */

                if ($persona) {

                    $persona->update(
                        $datosPersona
                    );

                    $actualizados++;
                }

                /*
                |--------------------------------------------------------------------------
                | CREAR
                |--------------------------------------------------------------------------
                */

                else {

                    Persona::create(
                        [

                            'cuil' =>
                                trim(
                                    $item['cuil']
                                ),

                            ...$datosPersona
                        ]
                    );

                    $creados++;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | CONFIRMAR TRANSACCIÓN
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | RESPUESTA
            |--------------------------------------------------------------------------
            */

            return response()->json(
                [
                    'message' =>
                        'Importación realizada correctamente.',

                    'total' =>
                        count($personas),

                    'creados' =>
                        $creados,

                    'actualizados' =>
                        $actualizados,

                    'catalogos_creados' => [

                        'obras_sociales' =>
                            $obrasSocialesCreadas,

                        'localidades' =>
                            $localidadesCreadas,

                        'relaciones_laborales' =>
                            $relacionesLaboralesCreadas,

                        'empresas' =>
                            $empresasCreadas
                    ]
                ],
                200
            );

        }

        catch (\Throwable $e) {

            DB::rollBack();


            return response()->json(
                [
                    'message' =>
                        'No fue posible guardar las personas.',

                    'error' =>
                        $e->getMessage()
                ],
                500
            );
        }
    }

    public function listarSexos()
    {
        try {

            $sexos =
                Persona::listarSexos();

            return response()->json(
                $sexos,
                200
            );

        } catch (\Throwable $e) {

            return response()->json(
                [
                    'message' =>
                        'No fue posible obtener los sexos.',

                    'error' =>
                        $e->getMessage()
                ],
                500
            );

        }
    }
    public function listarPersonasPorSexo(string $sexo)
    {
        try {

            $personas =
                Persona::listarPersonasPorSexo(
                    $sexo
                );

            return response()->json(
                $personas,
                200
            );

        } catch (\Throwable $e) {

            return response()->json(
                [
                    'message' =>
                        'No fue posible obtener las personas.',

                    'error' =>
                        $e->getMessage()
                ],
                500
            );

        }
    }
}
