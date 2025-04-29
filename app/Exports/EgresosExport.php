<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EgresosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('asistentes')
            ->join('egresos', 'asistentes.id', '=', 'egresos.asistente_id')
            ->select([
                'asistentes.apellido',
                'asistentes.nombre',
                'asistentes.dni',
                'asistentes.legajo',
                'asistentes.seccional',
                'egresos.registrado_en as fecha_egreso',
            ])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Apellido',
            'Nombre',
            'DNI',
            'Legajo',
            'Seccional',
            'Fecha y hora de Egreso',
        ];
    }
}