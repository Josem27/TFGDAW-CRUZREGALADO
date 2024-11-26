<?php

namespace App\Exports;

use App\Models\Pagos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Obtenemos los pagos que queremos exportar
        return Pagos::all(['id_usuario', 'fecha_pago', 'cantidad', 'método_pago', 'estado_pago']);
    }

    public function headings(): array
    {
        return [
            'ID Usuario',
            'Fecha de Pago',
            'Cantidad',
            'Método de Pago',
            'Estado de Pago'
        ];
    }
}