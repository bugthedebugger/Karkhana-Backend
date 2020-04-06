<?php

use Illuminate\Database\Seeder;
use App\Model\Page;
use App\Model\Section;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Landing page sections:
         * 1. slider
         * 2. about
         */
        $landingPage = Page::where('code', 'landing')->first();

        $landingSections = Section::create([
            'code' => 'landing',
            'page_id' => $landingPage->id,
        ]);
    }
}
