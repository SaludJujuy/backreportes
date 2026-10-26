<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RelacionLaboral;

class Conrolador_RelacionLaboral extends Controller
{
    public function listarRelacionLaboral()
    {
        $relacionesLaborales = RelacionLaboral::listarRelacionLaboral();
        return response()->json($relacionesLaborales);
    }

    public function obtenerRelacionLaboral($id)
    {
        $relacionLaboral = RelacionLaboral::listarRelacionLaboralPorId($id);
        if ($relacionLaboral) {
            return response()->json($relacionLaboral);
        } else {
            return response()->json(['message' => 'Relación laboral no encontrada'], 404);
        }
    }

    public function crearRelacionLaboral(Request $request)
    {
        $data = $request->only(['nombre', 'siglas']);
        $relacionLaboral = RelacionLaboral::crearRelacionLaboral($data);
        return response()->json($relacionLaboral, 201);
    }

    public function actualizarRelacionLaboral(Request $request, $id)
    {
        $data = $request->only(['nombre', 'siglas']);
        $relacionLaboral = RelacionLaboral::actualizarRelacionLaboral($id, $data);
        if ($relacionLaboral) {
            return response()->json($relacionLaboral);
        } else {
            return response()->json(['message' => 'Relación laboral no encontrada'], 404);
        }
    }

    public function eliminarRelacionLaboral($id)
    {
        $eliminado = RelacionLaboral::eliminarRelacionLaboral($id);
        if ($eliminado) {
            return response()->json(['message' => 'Relación laboral eliminada correctamente']);
        } else {
            return response()->json(['message' => 'Relación laboral no encontrada'], 404);
        }
    }
}
