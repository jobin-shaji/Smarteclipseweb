<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GpsRenewalExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection()
    {
        return DB::table('gps_orders as o')
            ->join('gps_summery as g', 'g.id', '=', 'o.gps_id')
            ->leftJoin('users as u', 'u.id', '=', 'o.sales_by')
            ->whereBetween('g.pay_date', [$this->startDate, $this->endDate])
            ->select(
                'o.id',
                'u.username',
                'g.imei',
                'g.serial_no',
                'g.vehicle_no',
                'g.amount',
                'g.renewed_by',
                'g.pay_date',
                'g.validity_date',
                'o.created_at'
            )
            ->orderBy('g.pay_date', 'desc')
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->username,
            "\t".$row->imei,          // IMEI as plain string
            "\t".$row->serial_no,
            $row->vehicle_no,
            $row->amount,
            $row->renewed_by,
            $row->pay_date,
            $row->validity_date,
            $row->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Employee',
            'IMEI',
            'serial_no',
            'Vehicle No',
            'Amount',
            'Renewed By',
            'Pay Date',
            'Validity Date',
            'Created At',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT, // IMEI column
        ];
    }
}
