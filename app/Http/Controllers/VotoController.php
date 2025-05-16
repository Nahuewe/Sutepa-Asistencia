<?php

namespace App\Http\Controllers;

use App\Exports\VotosExport;
use App\Http\Resources\VotoResource;
use App\Models\Voto;
use App\Services\VotoService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VotoController extends Controller
{
    protected VotoService $VotoService;

    public function index()
    {
        $Voto = $this->VotoService->VotoLista();

        return VotoResource::collection($Voto);
    }

    public function __construct(VotoService $VotoService)
    {
        $this->VotoService = $VotoService;
    }

    public function show($id)
    {
        $Voto = $this->VotoService->verVoto($id);

        if (!$Voto) {
            return response()->json(['message' => 'Votación no encontrada'], 404);
        }

        return new VotoResource($Voto);
    }

    public function store(Request $request)
    {
        $Voto = $this->VotoService->registrarVoto($request->all());

        return response()->json($Voto);
    }

    public function verificarVoto(Request $request)
    {
        $request->validate([
            'votacion_id'  => 'required|exists:votacions,id',
            'asistente_id' => 'required|exists:users,id',
        ]);

        $yaVoto = Voto::where('votacion_id', $request->votacion_id)
                    ->where('asistente_id', $request->asistente_id)
                    ->exists();

        return response()->json(['ya_voto' => $yaVoto]);
    }

    public function votosPorVotacion($votacion_id)
    {
        $votos = Voto::with('asistente')
            ->where('votacion_id', $votacion_id)
            ->get()
            ->map(function ($voto) {
                return [
                    'asistente_id' => $voto->asistente_id,
                    'nombre'       => $voto->asistente->nombre   ?? 'Desconocido',
                    'apellido'     => $voto->asistente->apellido ?? 'Desconocido',
                    'respuesta'    => $voto->respuesta,
                    'ya_voto'      => true,
                    'created_at'   => $voto->created_at,
                ];
            });

        return response()->json($votos);
    }

    public function exportarVotos()
    {
        return Excel::download(new VotosExport(), 'votos.xlsx');
    }
}
