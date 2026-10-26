<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Controlador_Usuario extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::login($credentials['email'], $credentials['password']);

        if ($user) {
            // Generar un token de acceso para el usuario
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Revocar el token de acceso del usuario
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Cierre de sesión exitoso']);
    }

    public function listarUsuarios(){
        $listaUsuarios = User::listarUsuarios();
        return response()->json($listaUsuarios);
    }

    public function obtenerUsuario(int $id){
        $usuario = User::obtenerUsuario($id);
        if ($usuario) {
            return response()->json($usuario);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    public function crearUsuario(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'permiso_id' => 'required|integer',
        ]);

        $user = User::crearUsuario($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registro exitoso',
            'usuario' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'permiso_id' => $user->permiso_id,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function actualizarUsuario(Request $request,int $id)
    {
        // Validar los datos de actualización
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'permiso_id' => 'required|exists:permisos,id', // Asegúrate de que el permiso exista en la tabla permisos
        ]);

        // Actualizar el usuario
        $usuario = User::actualizarUsuario($id,$validatedData);

        if ($usuario) {
            return response()->json(['message' => 'Usuario actualizado exitosamente']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    public function eliminarUsuario(int $id)
    {
        $usuario = User::eliminarUsuario($id);

        if ($usuario) {
            return response()->json(['message' => 'Usuario eliminado exitosamente']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }
}
