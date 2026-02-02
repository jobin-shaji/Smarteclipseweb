<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientVehiclesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $vehicles;

    public function __construct(Collection $vehicles)
    {
        $this->vehicles = $vehicles;
    }

    public function collection()
    {
        return $this->vehicles->map(function ($v) {
            return [
                'Vehicle Name'    => $v->name,
                'Register Number' => $v->register_number,
                'IMEI'            => optional($v->gps)->imei,
                'Installation'    => $v->installation_date,
                'Validity Date'   => $v->validity_date,
                'Certificate'     => optional($v->gps)->warrenty_certificate,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Vehicle Name',
            'Register Number',
            'IMEI',
            'Installation Date',
            'Validity Date',
            'Warranty Certificate',
        ];
    }
}
