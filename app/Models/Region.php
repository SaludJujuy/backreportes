<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'pais',
        'provincia',
        'localidad',
        'codigo_postal',
    ];

    public static function listarRegiones(){
        $lista = Region::select('id','pais','provincia','localidad','codigo_postal')
        ->get();
        return $lista;
    }

    public static function listarRegionPorId(int $id){
        $region = Region::select('id','pais','provincia','localidad','codigo_postal')
        ->where('id',$id)
        ->first();
        return $region;
    }

    public static function crearRegion(array $data){
        $region = Region::create($data);
        return $region;
    }

    public static function actualizarRegion(int $id, array $data){
        $region = Region::find($id);
        if($region){
            $region->update($data);
            return $region;
        }
        return null;
    }

    public static function eliminarRegion(int $id){
        $region = Region::find($id);
        if($region){
            $region->delete();
            return true;
        }
        return false;
    }
}
