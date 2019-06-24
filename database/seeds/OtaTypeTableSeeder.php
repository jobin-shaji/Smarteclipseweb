
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Modules\Ota\Models\OtaType;

class OtaTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        DB::table('ota_types')->insert([
            'name' => 'Primary/Regulatory Purpose URL',
            'code' => 'PU'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Control Centre Number',
            'code' => 'M0'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Emergency State OFF',
            'code' => 'EO'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Emergency State Time Duration',
            'code' => 'ED',
            'default_value' => '30'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Sleep Time',
            'code' => 'ST'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Halt Time',
            'code' => 'HT'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Speed Limit',
            'code' => 'SL',
            'default_value' => '70'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Harsh Breaking Threshold',
            'code' => 'HBT'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Harsh Acceleration Threshold',
            'code' => 'HAT'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Rash Turning Threshold',
            'code' => 'RTT'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Low Battery Threshold',
            'code' => 'LBT',
            'default_value' => '20'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Tilt Angle',
            'code' => 'TA',
            'default_value' => '45'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Vehicle Registration Number',
            'code' => 'VN'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Data Update Rate in Motion Mode',
            'code' => 'UR',
            'default_value' => '20'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Data Update Rate in Halt Mode',
            'code' => 'URT',
            'default_value' => '1'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Data Update Rate in Sleep Mode',
            'code' => 'URS',
            'default_value' => '60'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Data Update Rate in Emergency Mode',
            'code' => 'URE',
            'default_value' => '5'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Data Update Rate of Full Packet',
            'code' => 'URF',
            'default_value' => '120'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Data Update Rate of Health Packets',
            'code' => 'URH',
            'default_value' => '60'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Vendor ID',
            'code' => 'VID'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Firmware Version',
            'code' => 'FV'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Default speed limit',
            'code' => 'DSL',
            'default_value' => '70'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Contact Mobile Number',
            'code' => 'M1'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Contact Mobile Number 2',
            'code' => 'M2'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Contact Mobile Number 3',
            'code' => 'M3'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'Geofence',
            'code' => 'GF'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'OTA Updated Mobile',
            'code' => 'OM'
        ]);

        DB::table('ota_types')->insert([
            'name' => 'OTA Updated URL',
            'code' => 'OU'
        ]);



		
    }
}


