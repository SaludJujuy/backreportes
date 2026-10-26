<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'cuil',
        'dni',
        'apellido',
        'nombre',
        'fecha_nacimiento',
        'edad',
        'telefono',
        'email',
        'direccion',
        'sexo',
        'obra_social_id',
        'localidad_id',
        'relacion_laboral_id',
        'empresa_id'
    ];

    public static function listarPersonas(){
         $lista = Persona::select(
            'personas.id',
            'personas.cuil',
            'personas.dni',
            'personas.apellido',
            'personas.nombre',
            'personas.fecha_nacimiento',
            'personas.edad',
            'personas.telefono',
            'personas.email',

            // En Angular utilizamos "domicilio"
            'personas.direccion as domicilio',

            'personas.sexo',

            /*
            |--------------------------------------------------------------------------
            | IDs
            |--------------------------------------------------------------------------
            */

            'personas.obra_social_id',
            'personas.localidad_id',
            'personas.relacion_laboral_id',
            'personas.empresa_id',

            /*
            |--------------------------------------------------------------------------
            | NOMBRES PARA MOSTRAR EN ANGULAR
            |--------------------------------------------------------------------------
            */

            'obra_socials.razon_social as obra_social',

            'regions.localidad as localidad',

            'relacion_laborals.nombre as relacion_laboral',

            'empresas.razon_social as empresa'
        )

        /*
        |--------------------------------------------------------------------------
        | OBRA SOCIAL
        |--------------------------------------------------------------------------
        */

        ->leftJoin(
            'obra_socials',
            'obra_socials.id',
            '=',
            'personas.obra_social_id'
        )

        /*
        |--------------------------------------------------------------------------
        | LOCALIDAD
        |--------------------------------------------------------------------------
        */

        ->leftJoin(
            'regions',
            'regions.id',
            '=',
            'personas.localidad_id'
        )

        /*
        |--------------------------------------------------------------------------
        | RELACION LABORAL
        |--------------------------------------------------------------------------
        */

        ->leftJoin(
            'relacion_laborals',
            'relacion_laborals.id',
            '=',
            'personas.relacion_laboral_id'
        )

        /*
        |--------------------------------------------------------------------------
        | EMPRESA
        |--------------------------------------------------------------------------
        */

        ->leftJoin(
            'empresas',
            'empresas.id',
            '=',
            'personas.empresa_id'
        )

        /*
        |--------------------------------------------------------------------------
        | ORDEN
        |--------------------------------------------------------------------------
        */

        ->orderBy(
            'personas.apellido',
            'asc'
        )

        ->orderBy(
            'personas.nombre',
            'asc'
        )

        ->get();


        return $lista;
    }

    public static function listarPersonaPorId(int $id){
        $persona = Persona::select('id','cuil','dni','apellido','nombre','fecha_nacimiento','edad','telefono','email','direccion','sexo','obra_social_id','localidad_id','relacion_laboral_id','empresa_id')
        ->where('id',$id)
        ->first();
        return $persona;
    }

    public static function crearPersona(array $data){
        $persona = Persona::create($data);
        return $persona;
    }

    public static function actualizarPersona(int $id, array $data){
        $persona = Persona::find($id);
        if($persona){
            $persona->update($data);
            return $persona;
        }
        return null;
    }

    public static function eliminarPersona(int $id){
        $persona = Persona::find($id);
        if($persona){
            $persona->delete();
            return true;
        }
        return false;
    }
}
