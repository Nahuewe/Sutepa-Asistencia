<?php

namespace App\Services;

use App\Models\Asistente;
use App\Models\Ingreso;
use App\Models\Egreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegistroService
{
    public function registrarIngreso(array $data)
    {
        return DB::transaction(function () use ($data) {
            $asistente = Asistente::firstOrCreate(
                ['legajo' => $data['legajo']],
                [
                    'nombre' => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'dni' => $data['dni'],
                    'seccional' => $data['seccional'],
                ]
            );

            return Ingreso::create([
                'asistente_id' => $asistente->id,
                'registrado_en' => Carbon::now('America/Argentina/Buenos_Aires'),
            ]);
        });
    }

    public function registrarEgreso(array $data)
    {
        return DB::transaction(function () use ($data) {
            $asistente = Asistente::where('legajo', $data['legajo'])->firstOrFail();

            return Egreso::create([
                'asistente_id' => $asistente->id,
                'registrado_en' => Carbon::now('America/Argentina/Buenos_Aires'),
            ]);
        });
    }

    public function buscarRegistro($query)
    {
        $usuarios = Asistente::where('legajo', 'LIKE', "%$query%")
            ->orWhere('nombre', 'LIKE', "%$query%")
            ->orWhere('apellido', 'LIKE', "%$query%")
            ->get();
    
        return $usuarios;
    }    
}
