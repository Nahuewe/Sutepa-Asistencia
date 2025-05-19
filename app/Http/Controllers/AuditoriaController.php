<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuditoriaResource;
use App\Services\AuditoriaService;

class AuditoriaController extends Controller
{
    protected $AuditoriaService;

    public function __construct(AuditoriaService $AuditoriaService)
    {
        $this->AuditoriaService = $AuditoriaService;
    }

    public function index()
    {
        $auditoria = $this->AuditoriaService->AuditoriaLista();

        return AuditoriaResource::collection($auditoria);
    }
}
