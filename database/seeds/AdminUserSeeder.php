<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Model\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => config('envKeys.admin.name'),
            'email' => config('envKeys.admin.email'),
            'password' => Hash::make(config('envKeys.admin.password')),
        ]);

        DB::table('roles')->insert([
            'name' => 'SuperAdmin',
            'description' => 'Has all the access',
            'is_admin' => 1
        ]);

        $user = User::where('email', config('envKeys.admin.email'))->first();

        $role = Role::where('name', 'SuperAdmin')->first();

        $user->roles()->attach($role->id);

    }
}
