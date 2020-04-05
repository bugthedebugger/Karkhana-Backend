<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'name' => 'Landing Page',
            'code' => 'landing',
            'description' => 'This is landing page',
        ]);

        DB::table('pages')->insert([
            'name' => 'About Page',
            'code' => 'about',
            'description' => 'This is about page',
        ]);

        DB::table('pages')->insert([
            'name' => 'Contact Page',
            'code' => 'contact',
            'description' => 'This is contact page',
        ]);
    }
}
