<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'cuit',
        'razon_social',
    ];

    public static function listarEmpresa(){
        $lista = Empresa::select('id','cuit','razon_social')
        ->get();
        return $lista;
    }

    public static function listarEmpresaPorId(int $id){
        $empresa = Empresa::select('id','cuit','razon_social')
        ->where('id',$id)
        ->first();
        return $empresa;
    }

    public static function crearEmpresa(array $data){
        $empresa = Empresa::create($data);
        return $empresa;
    }

    public static function actualizarEmpresa(int $id, array $data){
        $empresa = Empresa::find($id);
        if($empresa){
            $empresa->update($data);
            return $empresa;
        }
        return null;
    }

    public static function eliminarEmpresa(int $id){
        $empresa = Empresa::find($id);
        if($empresa){
            $empresa->delete();
            return true;
        }
        return false;
    }
}
