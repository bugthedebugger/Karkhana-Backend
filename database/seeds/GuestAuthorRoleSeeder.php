<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class GuestAuthorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Guest Author',
            'is_admin' => false,
            'description' => 'Guest author will not have any login credentials. So will not have access to any pages.'
        ]);
    }
}
