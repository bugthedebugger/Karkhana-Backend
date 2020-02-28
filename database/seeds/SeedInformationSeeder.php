<?php

use Illuminate\Database\Seeder;
use App\Model\SeedInformation;

class SeedInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeedInformation::create([
            'name' => 'AdminUserSeeder',
        ]);
        SeedInformation::create([
            'name' => 'LanguageSeeder',
        ]);
        SeedInformation::create([
            'name' => 'PageSeeder',
        ]);
    }
}
