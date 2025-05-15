<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'legajo'   => 'required|string|max:255|unique:users'
        ], [
            'legajo.unique' => 'El legajo ya está registrado.',
        ]);

        $user = User::create([
            'nombre'       => $request->nombre,
            'apellido'     => $request->apellido,
            'legajo'       => $request->legajo,
            'dni'          => $request->dni,
            'roles_id'     => $request->roles_id ?? 5,
            'seccional_id' => $request->seccional_id,
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'legajo'   => 'required|string',
        ]);

        $user = User::where('legajo', $request->legajo)->first();

        return response()->json([
            'token' => $user->createToken($request->legajo)->plainTextToken,
            'user'  => [
                "id"           => $user->id,
                "nombre"       => $user->nombre,
                "apellido"     => $user->apellido,
                "dni"          => $user->dni,
                "rol"          => $user->rol->nombre,
                "roles_id"     => (int) $user->roles_id,
                "seccional"    => $user->seccional->nombre,
                "seccional_id" => (int) $user->seccional_id,
                "legajo"       => $user->legajo
            ]
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'error' => 'Usuario no autenticado.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $currentToken = $user->currentAccessToken();

        if (! $currentToken) {
            return response()->json([
                'error' => 'Token no válido.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $newToken = $user->createToken('NewToken')->plainTextToken;

        return response()->json([
            'token' => $newToken,
            'user'  => [
                "id"           => $user->id,
                "nombre"       => $user->nombre,
                "apellido"     => $user->apellido,
                "dni"          => $user->dni,
                "rol"          => $user->rol->nombre,
                "roles_id"     => (int) $user->roles_id,
                "seccional"    => $user->seccional->nombre,
                "seccional_id" => (int) $user->seccional_id,
                "legajo"       => $user->legajo
            ]
        ], Response::HTTP_OK);
    }
}
