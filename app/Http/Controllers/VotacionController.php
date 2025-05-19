<?php

namespace App\Http\Controllers;

use App\Exports\VotacionesExport;
use App\Http\Resources\VotacionResource;
use App\Models\User;
use App\Models\Votacion;
use App\Services\VotacionService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VotacionController extends Controller
{
    protected VotacionService $votacionService;

    public function index()
    {
        $Votacion = $this->votacionService->VotacionLista();

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

    public function usuariosNoVotaron(Votacion $votacion)
    {
        $usuarios = User::whereNotIn('id', function ($query) use ($votacion) {
            $query->select('asistente_id')
                  ->from('votos')
                  ->where('votacion_id', $votacion->id);
        })
        ->select('id as asistente_id', 'nombre', 'apellido')
        ->get();

        return response()->json($usuarios);
    }

    public function detener($id)
    {
        $votacion = Votacion::find($id);

        if (!$votacion) {
            return response()->json(['message' => 'Votación no encontrada'], 404);
        }

        $votacion->activa_hasta = now();
        $votacion->save();

        return response()->json(['message' => 'Votación detenida correctamente']);
    }

    public function exportarVotaciones()
    {
        return Excel::download(new VotacionesExport(), 'votaciones.xlsx');
    }
}
