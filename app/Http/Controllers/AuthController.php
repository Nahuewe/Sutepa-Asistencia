<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'password' => 'required|string|min:2'
        ]);
    
        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'password' => Hash::make($request->password),
            'roles_id' => 4,
            'seccional_id' => $request->seccional_id,
        ]);
    
        return response()->json($user, 201);
    }    

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = User::where('apellido', $request->apellido)->first();

        // Verifica si el usuario existe y si la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'apellido' => ['El usuario es incorrecto.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->apellido)->plainTextToken,
            'user' => [
                "id" => $user->id,
                "nombre" => $user->nombre,
                "apellido" => $user->apellido,
                "rol" => $user->rol->nombre,
                "roles_id" => (int) $user->roles_id,
                "seccional" => $user->seccional->nombre,
                "seccional_id" => (int) $user->seccional_id,
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
            'user' => [
                "id" => $user->id,
                "nombre" => $user->nombre,
                "apellido" => $user->apellido,
                "rol" => $user->rol->nombre,
                "roles_id" => (int) $user->roles_id,
                "seccional" => $user->seccional->nombre,
                "seccional_id" => (int) $user->seccional_id
            ]
        ], Response::HTTP_OK);
    }
}
