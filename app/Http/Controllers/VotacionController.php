<?php

namespace App\Http\Controllers;

use App\Http\Resources\VotacionResource;
use Illuminate\Http\Request;
use App\Services\VotacionService;

class VotacionController extends Controller
{
    protected VotacionService $votacionService;

    public function index()
    {
        $Votacion=$this->votacionService->VotacionLista();
        return VotacionResource::collection($Votacion);
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
}
