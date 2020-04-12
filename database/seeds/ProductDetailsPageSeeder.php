<?php

use Illuminate\Database\Seeder;
use App\Model\Page;

class ProductDetailsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::create([
            'name' => 'Product details page',
            'code' => 'product-details',
            'description' => 'Product details page',
        ]);

        $page->sections()->create([
            'code' => 'product-details',
        ]);
    }
}
