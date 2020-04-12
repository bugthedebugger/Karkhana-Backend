<?php

use Illuminate\Database\Seeder;
use App\Model\Page;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::where('code', 'about')->first();
        $page->sections()->create([
            'code' => 'about',
        ]);
    }
}
