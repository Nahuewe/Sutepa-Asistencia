<?php

namespace App\Exports;

use App\Models\Voto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VotosExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Voto::with(['votacion', 'asistente'])
            ->get()
            ->map(function ($voto) {
                return [
                    'tipo_votacion' => $voto->votacion->tipo ?? '',
                    'identificador' => $voto->votacion->identificador ?? '',
                    'contenido' => $voto->votacion->contenido ?? '',
                    'respuesta' => ucfirst($voto->respuesta),
                    'apellido' => $voto->asistente->apellido ?? '',
                    'nombre' => $voto->asistente->nombre ?? '',
                    'dni' => $voto->asistente->dni ?? '',
                    'legajo' => $voto->asistente->legajo ?? '',
                    'seccional' => $voto->asistente->seccional ?? '',
                    'fecha' => $voto->created_at->format('d-m-Y'),
                    'hora' => $voto->created_at->format('H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tipo de Votación',
            'Identificador',
            'Pregunta',
            'Respuesta',
            'Apellido',
            'Nombre',
            'DNI',
            'Legajo',
            'Seccional',
            'Fecha',
            'Hora',
        ];
    }
}
