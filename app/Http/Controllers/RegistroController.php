<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegistroService;

class RegistroController extends Controller
{
    protected $registroService;

    public function __construct(RegistroService $registroService)
    {
        $this->registroService = $registroService;
    }

    public function registrarIngreso(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'dni' => 'required|string',
            'legajo' => 'required|string',
            'seccional' => 'required|string',
        ]);

        $this->registroService->registrarIngreso($validated);

        return response()->json(['message' => 'Ingreso registrado correctamente']);
    }

    public function registrarEgreso(Request $request)
    {
        $validated = $request->validate([
            'legajo' => 'required|string',
        ]);

        $this->registroService->registrarEgreso($validated);

        return response()->json(['message' => 'Egreso registrado correctamente']);
    }
}
