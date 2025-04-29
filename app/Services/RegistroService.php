<?php

namespace App\Services;

use App\Models\Asistente;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    
            User::firstOrCreate(
                ['legajo' => $data['legajo']],
                [
                    'nombre' => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'dni' => $data['dni'],
                    'password' => Hash::make($data['legajo']),
                    'roles_id' => 4,
                    'seccional_id' => $data['seccional_id'] ?? null,
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
            $asistente = Asistente::where('legajo', $data['legajo'])->first();
    
            if (!$asistente) {
                throw new \Exception("El afiliado con el legajo N° {$data['legajo']} aun no fue registrado al ingresar.");
            }
    
            return Egreso::create([
                'asistente_id' => $asistente->id,
                'registrado_en' => Carbon::now('America/Argentina/Buenos_Aires'),
            ]);
        });
    }

    public function buscarRegistro($query, $page = 1)
    {
        $asistentes = Asistente::where('legajo', 'LIKE', "%$query%")
            ->orWhere('nombre', 'LIKE', "%$query%")
            ->orWhere('apellido', 'LIKE', "%$query%")
            ->pluck('id');
        
        $ingresos = Ingreso::whereIn('asistente_id', $asistentes)
            ->with('asistente')
            ->paginate(10, ['*'], 'page', $page);
        
        return $ingresos;
    }    
}
