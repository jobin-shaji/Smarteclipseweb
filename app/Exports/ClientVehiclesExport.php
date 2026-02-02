<?php

namespace App\Exports;

use App\Modules\Vehicle\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientVehiclesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $client_id;

    public function __construct($client_id)
    {
        $this->client_id = $client_id;
    }

    public function collection()
    {
        return (new Vehicle())->getVehicleListBasedOnClient($this->client_id);
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->name ?? '',
            $vehicle->register_number ?? '',
            (string) optional($vehicle->gps)->imei, // TEXT SAFE
            optional($vehicle->vehicleType)->name ?? '',
            optional($vehicle->driver)->name ?? '',
            $vehicle->installation_date,
            $vehicle->validity_date,
        ];
    }

    public function headings(): array
    {
        return [
            'Vehicle Name',
            'Register Number',
            'IMEI',
            'Vehicle Type',
            'Driver',
            'Installation Date',
            'Validity Date',
        ];
    }
}
