<?php

namespace App\Http\Controllers;

use App\Services\OrdenDiariaService;
use App\Http\Resources\OrdenDiariaResource;
use Illuminate\Http\Request;

class OrdenDiariaController extends Controller
{
    protected $ordenDiarioService;

    public function __construct(OrdenDiariaService $ordenDiarioService)
    {
        $this->ordenDiarioService = $ordenDiarioService;
    }

    public function index()
    {
        $ordenes = $this->ordenDiarioService->ordenDiariaLista();
        return OrdenDiariaResource::collection($ordenes);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo' => 'required|string|max:255',
            'identificador' => 'required|string',
            'contenido' => 'required|string',
        ]);

        $orden = $this->ordenDiarioService->crearOrdenDiaria($data);
        return new OrdenDiariaResource($orden);
    }

    public function show($id)
    {
        $orden = $this->ordenDiarioService->obtenerPorId($id);
        return new OrdenDiariaResource($orden);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tipo' => 'required|string|max:255',
            'identificador' => 'required|string',
            'contenido' => 'required|string',
        ]);

        $orden = $this->ordenDiarioService->editarOrdenDiaria($id, $data);
        return new OrdenDiariaResource($orden);
    }

    public function destroy($id)
    {
        $this->ordenDiarioService->eliminarOrdenDiaria($id);
        return response()->json(['message' => 'Orden eliminada correctamente'], 200);
    }
}
