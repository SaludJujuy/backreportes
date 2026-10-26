<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'permiso_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function login(string $email, string $password)
    {
        $user = self::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public static function listarUsuarios()
    {
        return self::select(
            'id',
            'name',
            'email',
            'permiso_id'
        )->get();
    }

    public static function obtenerUsuario(int $id)
    {
        return self::select(
            'id',
            'name',
            'email',
            'permiso_id'
        )
        ->where('id', $id)
        ->first();
    }

    public static function crearUsuario(array $data)
    {
        return self::create($data);
    }

    public static function actualizarUsuario(int $id, array $data)
    {
        $usuario = self::find($id);

        if (!$usuario) {
            return null;
        }

        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->permiso_id = $data['permiso_id'];

        if (!empty($data['password'])) {
            $usuario->password = $data['password'];
        }

        $usuario->save();

        return $usuario;
    }

    public static function eliminarUsuario(int $id)
    {
        $usuario = self::find($id);

        if (!$usuario) {
            return null;
        }

        $usuario->delete();

        return $usuario;
    }
}
