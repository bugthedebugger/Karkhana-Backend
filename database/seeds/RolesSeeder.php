<?php

use Illuminate\Database\Seeder;
use App\Model\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        Role::create([
            'name' => 'Editor',
            'description' => 'Has access to all the blogs.',
            'is_admin' => false,
        ]);

        Role::create([
            'name' => 'Author',
            'description' => 'Has access to only their blogs.',
            'is_admin' => false,
        ]);
    }
}
