
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

        DB::table('alert_types')->insert([
            'code' => '16',
            'description' => 'Emergency button wiredisconnect/wirecut'
        ]);

        DB::table('alert_types')->insert([
            'code' => '03',
            'description' => 'Disconnect from main battery'
        ]);

        DB::table('alert_types')->insert([
            'code' => '17',
            'description' => 'Over speed'
        ]);

        DB::table('alert_types')->insert([
            'code' => '22',
            'description' => 'Tilt'
        ]);

        DB::table('alert_types')->insert([
            'code' => '23',
            'description' => 'Impact'
        ]);

        DB::table('alert_types')->insert([
            'code' => '20',
            'description' => 'Overspeed+ GF Entry'
        ]);

        DB::table('alert_types')->insert([
            'code' => '21',
            'description' => 'Overspeed + GF Exit'
        ]);

        DB::table('alert_types')->insert([
            'code' => '1',
            'description' => 'Location Update'
        ]);

        DB::table('alert_types')->insert([
            'code' => '2',
            'description' => 'Location Update (history)'
        ]);

        DB::table('alert_types')->insert([
            'code' => '7',
            'description' => 'Alert – Ignition ON'
        ]);

        DB::table('alert_types')->insert([
            'code' => '8',
            'description' => 'Alert – Ignition OFF'
        ]);

        DB::table('alert_types')->insert([
            'code' => '10',
            'description' => 'Alert – Emergency state ON*'
        ]);

        DB::table('alert_types')->insert([
            'code' => '11',
            'description' => 'Alert – emergency State OFF'
        ]);

        DB::table('alert_types')->insert([
            'code' => '12',
            'description' => 'Alert Over the air parameter change'
        ]);

        DB::table('alert_types')->insert([
            'code' => '25',
            'description' => 'Full Parameter Update'
        ]);



		
    }
}


