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
        $permission_sub_dealer = Permission::create(['name' => 'manage users']);
        $permission_client = Permission::create(['name' => 'client']);

        $rootUserRole = Role::create(['name' => 'root']);
        $rootUserRole->givePermissionTo($permission_root);
    
        $dealerUserRole = Role::create(['name' => 'dealer']);
        $dealerUserRole->givePermissionTo($permission_dealer);
    
        $subDealerUserRole = Role::create(['name' => 'sub_dealer']);
        $subDealerUserRole->givePermissionTo($permission_sub_dealer);

        $clientUserRole = Role::create(['name' => 'client']);
        $clientUserRole->givePermissionTo($permission_client);

        $user =  DB::table('users')->insert([
            'username' => 'vst',
            'mobile' => 123456,
            'email' => 'phpdeveloper01@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);


        User::where('username','vst')->first()->assignRole('root');

        $user = DB::table('users')->insert([
            'username' => 'dealer',
            'mobile' => 123453,
            'email' => 'phpdeveloper02@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        User::where('username','dealer')->first()->assignRole('dealer');	


        $user = DB::table('users')->insert([
            'username' => 'sub_dealer',
            'mobile' => 123453,
            'email' => 'phpdeveloper03@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        User::where('username','sub_dealer')->first()->assignRole('sub_dealer'); 


        $user = DB::table('users')->insert([
            'username' => 'client',
            'mobile' => 123453,
            'email' => 'phpdeveloper04@vehiclest.in',
            'password' => bcrypt('123456'),
            'status' => 1
        ]);

        User::where('username','client')->first()->assignRole('client'); 
		
    }
}
