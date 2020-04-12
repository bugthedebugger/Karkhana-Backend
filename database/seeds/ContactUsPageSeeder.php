<?php

use Illuminate\Database\Seeder;
use App\Model\Page;

class ContactUsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactPage = Page::where('code', 'contact')->first();
        $contactPage->sections()->create([
            'code' => 'contact'
        ]);
    }
}
