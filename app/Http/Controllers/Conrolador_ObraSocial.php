<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObraSocial;

class Conrolador_ObraSocial extends Controller
{
    public function listarObraSocial()
    {
        $obra_social = ObraSocial::listarObraSocial();
        return response()->json($obra_social);
    }

    public function obtenerObraSocial(int $id)
    {
        $obra_social = ObraSocial::listarObraSocialPorId($id);
        if ($obra_social) {
            return response()->json($obra_social);
        } else {
            return response()->json(['message' => 'Obra Social no encontrada'], 404);
        }
    }

    public function crearObraSocial(Request $request)
    {
        $data = $request->only(['razon_social', 'siglas']);
        $obra_social = ObraSocial::crearObraSocial($data);
        return response()->json($obra_social, 201);
    }

    public function actualizarObraSocial(Request $request, int $id)
    {
        $data = $request->only(['razon_social', 'siglas']);
        $obra_social = ObraSocial::actualizarObraSocial($id, $data);
        if ($obra_social) {
            return response()->json($obra_social);
        } else {
            return response()->json(['message' => 'Obra Social no encontrada'], 404);
        }
    }

    public function eliminarObraSocial(int $id)
    {
        $resultado = ObraSocial::eliminarObraSocial($id);
        if ($resultado) {
            return response()->json(['message' => 'Obra Social eliminada correctamente']);
        } else {
            return response()->json(['message' => 'Obra Social no encontrada'], 404);
        }
    }
}
