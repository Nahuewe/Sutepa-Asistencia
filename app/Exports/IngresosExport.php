<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IngresosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('asistentes')
            ->join('ingresos', 'asistentes.id', '=', 'ingresos.asistente_id')
            ->select([
                'asistentes.apellido',
                'asistentes.nombre',
                'asistentes.dni',
                'asistentes.legajo',
                'asistentes.seccional',
                'ingresos.registrado_en as fecha_ingreso',
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
            'Fecha y hora de Ingreso',
        ];
    }
}
