<?php

namespace App\Imports;
use App\Modules\Gps\Models\Gps;
use App\Modules\Client\Models\Client;
use App\Modules\User\Models\User;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\Warehouse\Models\GpsStock;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use \Carbon\Carbon;
use DB;
class KsrtcImport implements OnEachRow, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, WithChunkReading
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $rowCount = 0;

    public function rules(): array
    {
        return [
           
            'imei' => ['required']
            ];
    }

    public function chunkSize(): int
    {
        return 1500;
    }

   public function onRow(Row $row)
{
    $row = $row->toArray();
    $imei = preg_replace('/[^0-9]/', '', (string)$row['imei']); // clean IMEI

    $gps_old = Gps::where('imei', $imei)->first();
   // $gps_old = Gps::where('imei', $row['imei'])->whereNotNull('installation_date_new')->first();

    if (!$gps_old) {
        echo "No GPS found for IMEI: {$imei}\n";
        return;
    }

    try {
    $installation_date = trim($row['installed_date'] ?? '');
    $valid = trim($row['valid_upto'] ?? '');

   
    // Initialize with null to avoid undefined variable
    $previous = null;
    $valid_upto = null;

    // Parse installation_date safely
    if (!empty($installation_date)) {
        try {
            $previous = Carbon::createFromFormat('d/m/Y', $installation_date)->format('Y-m-d');
        } catch (\Exception $e) {
            // Try fallback formats
            try {
                $previous = Carbon::parse($installation_date)->format('Y-m-d');
            } catch (\Exception $e2) {
                $previous = null;
            }
        }
    }

    // Parse valid_upto safely
    if (!empty($valid)) {
        try {
            $valid_upto = Carbon::createFromFormat('d/m/Y', $valid)->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                $valid_upto = Carbon::parse($valid)->format('Y-m-d');
            } catch (\Exception $e2) {
                $valid_upto = null;
            }
        }
    }


  

   /* Gps::where('imei',  $imei)->update([
    'installation_date' => $previous,
    'installation_date_new' => $previous,
    'valid_upto' => $valid_upto,
    'validity_date' => $valid_upto,
    ///'vehicle_no' => trim($row['vehicle_no']) ?? '',
]);

 // Now safely assign to model
    $gps_old->installation_date = $previous;
    $gps_old->installation_date_new = $previous;
    $gps_old->valid_upto = $valid_upto;
    $gps_old->validity_date = $valid_upto;*/
   // $gps_old->vehicle_no = trim($row['vehicle_no'] ?? '');


     $vehicle=Vehicle::where('gps_id',$gps_old->id)->first();
     
            if (!$vehicle) {

                // $vehicle->installation_date=$previous;
                //  $vehicle->validity_date=$valid_upto;
                //  $vehicle->save();

                $vehicle = Vehicle::create([
                        'name' => trim($row['vehicle']) ?? '',
                        'register_number' =>trim($row['vehicle']) ?? '',
                        'vehicle_type_id' =>3,
                        'gps_id' => $gps_old->id,
                        'driver_id' => 0,
                       // 'chassis_number'=>trim($row['chassis_number']) ??'',
                        'installation_date'=>$previous,
                        'validity_date'=>$valid_upto,
                        'client_id' =>1778,
                        'status' =>1
                    ]);
            }
    // Debug changes
    if ($gps_old->isDirty()) {
       // print_r($gps_old->getDirty());
      //  $gps_old->save();

        $vehicle=Vehicle::where('gps_id',$gps_old->id)->first();
            if (!$vehicle) {

                $vehicle = Vehicle::create([
                        'name' => trim($row['vehicle_no']) ?? '',
                        'register_number' =>trim($row['vehicle_no']) ?? '',
                        'vehicle_type_id' =>3,
                        'gps_id' => $gps_old->id,
                        'driver_id' => 0,
                        //'chassis_number'=>trim($row['chassis_number']) ?? '',
                        'installation_date'=>$previous,
                        'validity_date'=>$valid_upto,
                        'client_id' =>1778,
                        'status' =>1
                    ]);
            }
        \DB::commit();

        echo "✅ Updated IMEI {$row['imei']} ({$previous})\n";
    } else {
        echo "⚠️ No changes for IMEI {$row['imei']} (same data)\n";
    }
} catch (\Throwable $e) {
    echo "❌ Error for IMEI {$row['imei']}: " . $e->getMessage() . "\n";
}

}

private function parseFlexibleDate($dateString)
{
    if (empty($dateString)) return null;

    $dateString = substr(trim($dateString), 0, 19); // remove trailing noise

    try {
        return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
    } catch (\Exception $e) {
        try {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $dateString)->format('Y-m-d');
        } catch (\Exception $e2) {
            return null;
        }
    }
}


    public function getTotalCount()
    {
        return $this->rowCount;
    }

    //vehicle type=3
    //client_id=1778
}
