<?php

namespace App\Http\Controllers;

use App\Http\Resources\VotoResource;
use Illuminate\Http\Request;
use App\Services\VotoService;

class VotoController extends Controller
{
    protected VotoService $VotoService;

    public function index()
    {
        $Voto=$this->VotoService->VotoLista();
        return VotoResource::collection($Voto);
    }

    public function __construct(VotoService $VotoService)
    {
        $this->VotoService = $VotoService;
    }

    public function store(Request $request)
    {
        $Voto = $this->VotoService->registrarVoto($request->all());
        return response()->json($Voto);
    }
}
