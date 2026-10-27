<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class Conrolador_Region extends Controller
{
    public function listarRegiones()
    {
        $regiones = Region::listarRegiones();
        return response()->json($regiones);
    }

    public function listarRegionesParaFiltro()
    {
        $regiones = Region::listarRegionesParaFiltro();
        return response()->json($regiones);
    }

    public function obtenerRegion(int $id)
    {
        $region = Region::listarRegionPorId($id);
        if ($region) {
            return response()->json($region);
        } else {
            return response()->json(['message' => 'Región no encontrada'], 404);
        }
    }

    public function crearRegion(Request $request)
    {
        $data = $request->all();
        $region = Region::crearRegion($data);
        return response()->json($region, 201);
    }

    public function actualizarRegion(Request $request, int $id)
    {
        $data = $request->all();
        $region = Region::actualizarRegion($id, $data);
        if ($region) {
            return response()->json($region);
        } else {
            return response()->json(['message' => 'Región no encontrada'], 404);
        }
    }

    public function eliminarRegion(int $id)
    {
        $eliminado = Region::eliminarRegion($id);
        if ($eliminado) {
            return response()->json(['message' => 'Región eliminada correctamente']);
        } else {
            return response()->json(['message' => 'Región no encontrada'], 404);
        }
    }
}
