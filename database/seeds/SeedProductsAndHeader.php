<?php

use Illuminate\Database\Seeder;
use App\Model\Page;
use App\Model\Section;

class SeedProductsAndHeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsPage = Page::create([
            'name' => 'Products Page',
            'code' => 'products',
            'description' => 'This is products page',
        ]);

        $productSection = Section::create([
            'code' => 'products',
            'page_id' => $productsPage->id,
        ]);

        $pageHeader = Page::create([
            'name' => 'Page Header',
            'code' => 'header',
            'description' => 'This is header of pages',
        ]);

        $pageHeaderSection = Section::create([
            'code' => 'header',
            'page_id' => $pageHeader->id,
        ]);

    }
}
