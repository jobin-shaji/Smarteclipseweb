<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Modules\Alert\Models\AlertType;

class AlertTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        DB::table('alert_types')->insert([
            'code' => '13',
            'description' => 'Harsh Braking'
        ]);

        DB::table('alert_types')->insert([
            'code' => '14',
            'description' => 'Harsh Acceleration'
        ]);

        DB::table('alert_types')->insert([
            'code' => '15',
            'description' => 'Rash Turning'
        ]);

        DB::table('alert_types')->insert([
            'code' => '09',
            'description' => 'GPS Box Opened'
        ]);

        DB::table('alert_types')->insert([
            'code' => '18',
            'description' => 'Geofence Entry'
        ]);

        DB::table('alert_types')->insert([
            'code' => '19',
            'description' => 'Geofence Exit'
        ]);

        DB::table('alert_types')->insert([
            'code' => '06',
            'description' => 'Vehicle Battery Reconnect/ Connect back to main battery'
        ]);

        DB::table('alert_types')->insert([
            'code' => '04',
            'description' => 'Low battery'
        ]);

        DB::table('alert_types')->insert([
            'code' => '05',
            'description' => 'Low battery removed'
        ]);

		
    }
}
