<?php

use Illuminate\Database\Seeder;
use App\Model\Page;

class SettingsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
            'name' => 'Settings page',
            'code' => 'settings',
            'description' => 'Settings page'
        ]);
    }
}
