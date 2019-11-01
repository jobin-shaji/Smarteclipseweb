<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Modules\User\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // factory(App\Modules\User\Models\User::class, 25)->create();

        $permission_root = Permission::create(['name' => 'manage dealers']);
        $permission_dealer = Permission::create(['name' => 'manage subdealers']);
        $permission_sub_dealer = Permission::create(['name' => 'manage clients']);
        $permission_client = Permission::create(['name' => 'client']);
        // $permission_servicer = Permission::create(['name' => 'servicer']);
        



        $rootUserRole = Role::create(['name' => 'root']);
        $rootUserRole->givePermissionTo($permission_root);
    
        $dealerUserRole = Role::create(['name' => 'dealer']);
        $dealerUserRole->givePermissionTo($permission_dealer);
    
        $subDealerUserRole = Role::create(['name' => 'sub_dealer']);
        $subDealerUserRole->givePermissionTo($permission_sub_dealer);

        $clientUserRole = Role::create(['name' => 'client']);
        $clientUserRole->givePermissionTo($permission_client);

        $servicerUserRole = Role::create(['name' => 'servicer']);
        // $servicerUserRole->givePermissionTo($permission_servicer);

        $fundamentalUserRole = Role::create(['name' => 'fundamental']);
        $superiorUserRole = Role::create(['name' => 'superior']);
        $proUserRole = Role::create(['name' => 'pro']);
        $schoolUserRole = Role::create(['name' => 'school']);
        $schoolPremiumUserRole = Role::create(['name' => 'school_premium']);
        

        $user =  DB::table('users')->insert([
            'username' => 'vst',
            'mobile' => 123456,
            'email' => 'phpdeveloper01@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        DB::table('roots')->insert([
            'address' => 'vst',
            'name' => 'vst',
            'user_id'=>1,
        ]);



        User::where('username','vst')->first()->assignRole('root');

        $user = DB::table('users')->insert([
            'username' => 'dealer',
            'mobile' => 123453,
            'email' => 'phpdeveloper02@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        DB::table('dealers')->insert([
            'address' => 'vst',
            'name' => 'dealer',
            'user_id'=>2,
            'root_id' => 1
        ]);

        User::where('username','dealer')->first()->assignRole('dealer');	


        $user = DB::table('users')->insert([
            'username' => 'sub_dealer',
            'mobile' => 123453,
            'email' => 'phpdeveloper03@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        DB::table('sub_dealers')->insert([
            'address' => 'vst',
            'name' => 'sub_dealer',
            'user_id'=>3,
            'dealer_id' => 1
        ]);

        User::where('username','sub_dealer')->first()->assignRole('sub_dealer'); 


        $user = DB::table('users')->insert([
            'username' => 'client',
            'mobile' => 123453,
            'email' => 'phpdeveloper04@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1,
            'role' => 0
        ]);
        DB::table('clients')->insert([
            'address' => 'vst',
            'name' => 'client',
            'user_id'=>4,
            'sub_dealer_id' => 1
        ]);
  
        User::where('username','client')->first()->assignRole('client'); 

        DB::table('document_types')->insert([
            'name' => 'RC Book'
        ]);

        DB::table('document_types')->insert([
            'name' => 'Insurance'
        ]);

        DB::table('document_types')->insert([
            'name' => 'Pollution Document'
        ]);

        DB::table('document_types')->insert([
            'name' => 'Permit'
        ]);

        DB::table('document_types')->insert([
            'name' => 'Tax Document'
        ]);
        DB::table('document_types')->insert([
            'name' => 'Installation Photo'
        ]);
        DB::table('document_types')->insert([
            'name' => 'Activation Photo'
        ]);
        DB::table('document_types')->insert([
            'name' => 'Vehicle Photo'
        ]);

        DB::table('vehicle_types')->insert([
            'name' => 'Car',
            'status' => 0,
            'svg_icon' => 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
            'vehicle_scale'=>'0.50',
            'opacity' => '0.50',
            'strokeWeight' =>'1.00'
        ]);

        DB::table('plans')->insert([
            'name' => 'Freebies(Renewal)'
        ]);
        DB::table('plans')->insert([
            'name' => 'Fundamental(upgrade)'
        ]);
        DB::table('plans')->insert([
            'name' => 'Superior(upgrade)'
        ]);
        DB::table('plans')->insert([
            'name' => 'Pro'
        ]);
        DB::table('plans')->insert([
            'name' => 'Hardware Warranty(for one year)'
        ]);
        DB::table('plans')->insert([
            'name' => 'Hardware Warranty(for 4 year)'
        ]);


        DB::table('subscriptions')->insert([
            'plan_id' => 1,
            'country_id'=>101,
            'amount'=>1700
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 2,
            'country_id'=>101,
            'amount'=>2400
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 3,
            'country_id'=>101,
            'amount'=>3100
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 4,
            'country_id'=>101,
            'amount'=>500000
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 5,
            'country_id'=>101,
            'amount'=>800
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 6,
            'country_id'=>101,
            'amount'=>2800
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 1,
            'country_id'=>178,
            'amount'=>85
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 2,
            'country_id'=>178,
            'amount'=>120
        ]);
        DB::table('subscriptions')->insert([
            'plan_id' => 3,
            'country_id'=>178,
            'amount'=>155
        ]);      
        DB::table('subscriptions')->insert([
            'plan_id' => 4,
            'country_id'=>178,
            'amount'=>25000
        ]);
        
    }
}
