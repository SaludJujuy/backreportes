<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObraSocial extends Model
{
    protected $fillable = [
        'razon_social',
        'siglas',
    ];

    public static function listarObraSocial(){
        $lista = ObraSocial::select('id','razon_social','siglas')
        ->get();
        return $lista;
    }

    public static function listarObraSocialParaFiltro(){
        $lista = ObraSocial::select('siglas')
        ->get();
        return $lista;
    }

    public static function listarObraSocialPorId(int $id){
        $obra_social = ObraSocial::select('id','razon_social','siglas')
        ->where('id',$id)
        ->first();
        return $obra_social;
    }

    public static function crearObraSocial(array $data){
        $obra_social = ObraSocial::create($data);
        return $obra_social;
    }

    public static function actualizarObraSocial(int $id, array $data){
        $obra_social = ObraSocial::find($id);
        if($obra_social){
            $obra_social->update($data);
            return $obra_social;
        }
        return null;
    }

    public static function eliminarObraSocial(int $id){
        $obra_social = ObraSocial::find($id);
        if($obra_social){
            $obra_social->delete();
            return true;
        }
        return false;
    }

}
