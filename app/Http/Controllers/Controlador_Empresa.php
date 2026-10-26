<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class Controlador_Empresa extends Controller
{
    public function listarEmpresas()
    {
        $empresas = Empresa::listarEmpresa();
        return response()->json($empresas);
    }

    public function obtenerEmpresa($id)
    {
        $empresa = Empresa::listarEmpresaPorId($id);
        if ($empresa) {
            return response()->json($empresa);
        } else {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }
    }

    public function crearEmpresa(Request $request)
    {
        $data = $request->only(['cuit', 'razon_social']);
        $empresa = Empresa::crearEmpresa($data);
        return response()->json($empresa, 201);
    }

    public function actualizarEmpresa(Request $request, int $id)
    {
        $data = $request->only(['cuit', 'razon_social']);
        $empresa = Empresa::actualizarEmpresa($id, $data);
        if ($empresa) {
            return response()->json($empresa);
        } else {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }
    }

    public function eliminarEmpresa(int$id)
    {
        $resultado = Empresa::eliminarEmpresa($id);
        if ($resultado) {
            return response()->json(['message' => 'Empresa eliminada correctamente']);
        } else {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }
    }
}
