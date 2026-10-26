<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelacionLaboral extends Model
{
    protected $fillable = [
        'nombre',
        'siglas',
    ];

    public static function listarRelacionLaboral(){
        $lista = RelacionLaboral::select('id','nombre','siglas')
        ->get();
        return $lista;
    }

    public static function listarRelacionLaboralPorId(int $id){
        $relacionLaboral = RelacionLaboral::select('id','nombre','siglas')
        ->where('id',$id)
        ->first();
        return $relacionLaboral;
    }

    public static function crearRelacionLaboral(array $data){
        $relacionLaboral = RelacionLaboral::create($data);
        return $relacionLaboral;
    }

    public static function actualizarRelacionLaboral(int $id, array $data){
        $relacionLaboral = RelacionLaboral::find($id);
        if($relacionLaboral){
            $relacionLaboral->update($data);
            return $relacionLaboral;
        }
        return null;
    }

    public static function eliminarRelacionLaboral(int $id){
        $relacionLaboral = RelacionLaboral::find($id);
        if($relacionLaboral){
            $relacionLaboral->delete();
            return true;
        }
        return false;
    }
}
