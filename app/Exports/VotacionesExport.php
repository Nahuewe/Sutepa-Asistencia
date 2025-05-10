<?php

namespace App\Exports;

use App\Models\Votacion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VotacionesExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Votacion::withCount([
            'votos as afirmativos'  => fn ($q) => $q->where('respuesta', 'afirmativo'),
            'votos as negativos'    => fn ($q) => $q->where('respuesta', 'negativo'),
            'votos as abstenciones' => fn ($q) => $q->where('respuesta', 'abstencion'),
        ])
        ->get()
        ->map(function ($votacion) {
            $fechaHoraArg = Carbon::parse($votacion->created_at)
                                ->setTimezone('America/Argentina/Buenos_Aires');

            return [
                'tipo'          => $votacion->tipo                                                         ?? '-',
                'identificador' => $votacion->identificador                                                ?? '-',
                'contenido'     => $votacion->contenido                                                    ?? '-',
                'afirmativos'   => $votacion->afirmativos                                                  ?? '-',
                'negativos'     => $votacion->negativos                                                    ?? '-',
                'abstenciones'  => $votacion->abstenciones                                                 ?? '-',
                'total_votos'   => $votacion->afirmativos + $votacion->negativos + $votacion->abstenciones ?? '-',
                'fecha'         => $fechaHoraArg->format('d-m-Y'),
                'hora'          => $fechaHoraArg->format('H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tipo',
            'Identificador',
            'Pregunta',
            'Afirmativos',
            'Negativos',
            'Abstenciones',
            'Total de Votos',
            'Fecha',
            'Hora',
        ];
    }
}
