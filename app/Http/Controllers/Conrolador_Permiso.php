<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;

class Conrolador_Permiso extends Controller
{
    public function listarPermisos()
    {
        $permisos = Permiso::listarPermisos();
        return response()->json($permisos);
    }

    public function obtenerPermiso(int $id)
    {
        $permiso = Permiso::listarPermisoPorId($id);
        if ($permiso) {
            return response()->json($permiso);
        } else {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }
    }

    public function crearPermiso(Request $request)
    {
        $data = $request->only(['nivel', 'nombre']);
        $permiso = Permiso::crearPermiso($data);
        return response()->json($permiso, 201);
    }

    public function actualizarPermiso(Request $request, int $id)
    {
        $data = $request->only(['nivel', 'nombre']);
        $permiso = Permiso::actualizarPermiso($id, $data);
        if ($permiso) {
            return response()->json($permiso);
        } else {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }
    }

    public function eliminarPermiso(int $id)
    {
        $eliminado = Permiso::eliminarPermiso($id);
        if ($eliminado) {
            return response()->json(['message' => 'Permiso eliminado correctamente']);
        } else {
            return response()->json(['message' => 'Permiso no encontrado'], 404);
        }
    }
}
