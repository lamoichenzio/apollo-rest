<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = new Role([
            "name"=>"ADMIN",
            "description"=>"Admin Role"
        ]);
        $adminRole->save();

        $standardRole = new Role([
            "name"=>"STANDARD",
            "description"=>"Standard Role"
        ]);
        $standardRole->save();

        $admin = new \App\User([
            'username'=>'admin',
            'password'=>Hash::make('admin'),
            'email'=>'admin@admin.it',
            'role_id' => 1
        ]);

        $admin->save();

        factory(App\User::class,2)->create(['role_id'=>'2']);
    }
}
