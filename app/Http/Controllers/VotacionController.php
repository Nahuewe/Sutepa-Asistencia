<?php

namespace App\Http\Controllers;

use App\Exports\VotacionesExport;
use App\Exports\VotosExport;
use App\Http\Resources\VotacionResource;
use App\Models\User;
use App\Models\Votacion;
use Illuminate\Http\Request;
use App\Services\VotacionService;
use Maatwebsite\Excel\Facades\Excel;

class VotacionController extends Controller
{
    protected VotacionService $votacionService;

    public function index()
    {
        $Votacion=$this->votacionService->VotacionLista();
        return VotacionResource::collection($Votacion);
    }

    public function show($id)
    {
        $votacion = $this->votacionService->verVotacion($id);
    
        if (!$votacion) {
            return response()->json(['message' => 'Votación no encontrada'], 404);
        }
    
        return new VotacionResource($votacion);
    }    

    public function __construct(VotacionService $votacionService)
    {
        $this->votacionService = $votacionService;
    }

    public function store(Request $request)
    {
        $votacion = $this->votacionService->crearVotacion($request->all());
        return response()->json($votacion);
    }

    public function obtenerConteo($id)
    {
        $votacion = Votacion::findOrFail($id);

        $conteo = [
            'afirmativo' => $votacion->votos()->where('respuesta', 'afirmativo')->count(),
            'negativo' => $votacion->votos()->where('respuesta', 'negativo')->count(),
            'abstencion' => $votacion->votos()->where('respuesta', 'abstencion')->count(),
        ];

        return response()->json($conteo);
    }

    public function usuariosNoVotaron(Votacion $votacion)
{
    // Traemos todos los usuarios que tienen cuenta
    // y no existen en votos para esta votación.
    $usuarios = User::whereDoesntHave('votos', function($q) use ($votacion) {
        $q->where('votacion_id', $votacion->id);
    })
    ->select(['id as asistente_id', 'nombre', 'apellido'])
    ->get();

    return response()->json($usuarios);
}


    public function exportarVotaciones(Request $request)
    {
        return Excel::download(new VotacionesExport, 'votaciones.xlsx');
    }
}
