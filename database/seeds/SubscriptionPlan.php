<?php

use Illuminate\Database\Seeder;

class SubscriptionPlan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trip_report_configurations')->insert([
            'plan_id'                           => 0,
            'number_of_report_per_month'        => 31,
            'backup_days'                       => 60,
            'free_vehicle'                      => 0,
            'created_at'                        => date('Y-m-d H:i:s'),
            'updated_at'                        => date('Y-m-d H:i:s')
        ]);

        DB::table('trip_report_configurations')->insert([
            'plan_id'                           => 1,
            'number_of_report_per_month'        => 31,
            'backup_days'                       => 60,
            'free_vehicle'                      => 0,
            'created_at'                        => date('Y-m-d H:i:s'),
            'updated_at'                        => date('Y-m-d H:i:s')
        ]);

        DB::table('trip_report_configurations')->insert([
            'plan_id'                           => 2,
            'number_of_report_per_month'        => 31,
            'backup_days'                       => 60,
            'free_vehicle'                      => 1,
            'created_at'                        => date('Y-m-d H:i:s'),
            'updated_at'                        => date('Y-m-d H:i:s')
        ]);

        DB::table('trip_report_configurations')->insert([
            'plan_id'                           => 3,
            'number_of_report_per_month'        => 31,
            'backup_days'                       => 60,
            'free_vehicle'                      => 1,
            'created_at'                        => date('Y-m-d H:i:s'),
            'updated_at'                        => date('Y-m-d H:i:s')
        ]);
    }
}
