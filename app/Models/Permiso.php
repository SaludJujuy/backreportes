<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $fillable = [
        'nivel',
        'nombre'
    ];

    public static function listarPermisos(){
        $lista = Permiso::select('id','nivel','nombre')
        ->get();
        return $lista;
    }

    public static function listarPermisoPorId(int $id){
        $permiso = Permiso::select('id','nivel','nombre')
        ->where('id',$id)
        ->first();
        return $permiso;
    }

    public static function crearPermiso(array $data){
        $permiso = Permiso::create($data);
        return $permiso;
    }

    public static function actualizarPermiso(int $id, array $data){
        $permiso = Permiso::find($id);
        if($permiso){
            $permiso->update($data);
            return $permiso;
        }
        return null;
    }

    public static function eliminarPermiso(int $id){
        $permiso = Permiso::find($id);
        if($permiso){
            $permiso->delete();
            return true;
        }
        return false;
    }
}
