<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomizeException;
use App\Http\Resources\RegistroResource;
use Illuminate\Http\Response;
use App\Models\Egreso;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use App\Services\RegistroService;

class RegistroController extends Controller
{
    protected $RegistroService;

    public function __construct(RegistroService $RegistroService)
    {
        $this->RegistroService = $RegistroService;
    }

    public function registrarIngreso(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'dni' => 'required|string',
            'legajo' => 'required|string',
            'seccional' => 'nullable|string',
        ]);

        $this->RegistroService->registrarIngreso($validated);

        return response()->json(['message' => 'Ingreso registrado correctamente']);
    }

    public function registrarEgreso(Request $request)
    {
        $validated = $request->validate([
            'legajo' => 'required|string',
        ]);

        $this->RegistroService->registrarEgreso($validated);

        return response()->json(['message' => 'Egreso registrado correctamente']);
    }

    public function getIngresos(Request $request)
    {
        $page = $request->query('page', 1);
        $ingresos = Ingreso::with('asistente')
            ->paginate(10, ['*'], 'page', $page);

        return response()->json([
            'data' => $ingresos->items(),
            'meta' => [
                'total' => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'last_page' => $ingresos->lastPage(),
                'per_page' => $ingresos->perPage(),
                'from' => $ingresos->firstItem(),
                'to' => $ingresos->lastItem(),
            ]
        ]);
    }
    
    public function getEgresos(Request $request)
    {
        $page = $request->query('page', 1);
        $egresos = Egreso::with('asistente')
            ->paginate(10, ['*'], 'page', $page); 

        return response()->json([
            'data' => $egresos->items(),
            'meta' => [
                'total' => $egresos->total(),
                'current_page' => $egresos->currentPage(),
                'last_page' => $egresos->lastPage(),
                'per_page' => $egresos->perPage(),
                'from' => $egresos->firstItem(),
                'to' => $egresos->lastItem(),
            ]
        ]);
    }

    public function buscarRegistro(Request $request)
    {
        try {
            $query = $request->input('query');
            $registros = $this->RegistroService->buscarRegistro($query);
    
            return RegistroResource::collection($registros);
        } catch (\Exception $e) {
            throw new CustomizeException('Seccional no encontrada', Response::HTTP_NOT_FOUND);
        }
    }
}
