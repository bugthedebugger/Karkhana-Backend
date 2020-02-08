<?php

use App\Model\Page;
use App\Model\Section;
use App\Model\Language;
use Illuminate\Database\Seeder;
use App\Model\SectionTranslation;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::where('code','landing')->first();
        $sectionCover = Section::create([
        	'code' => 'landing_cover_photo',
        	'page_id' => $page->id
        ]);

        $sectionAbout = Section::create([
        	'code' => 'landing_about',
        	'page_id' => $page->id
        ]);

        $sectionPartners = Section::create([
        	'code' => 'landing_partners',
        	'page_id' => $page->id
        ]);

        $language = Language::where('language', 'en')->first();

        $jsonCover = ["slider"=> [
        					"photos"=> [
        						["path"=> "path", "order"=> 0], ["path"=> "path", "order"=> 1]
        					]
        				]
        			];

        $jsonAbout = ['title' => 'About',
        				'text' => 'text',
        				'data' => [
        					'students_reached' => '10000+',
        					'schools_we_reached' => '1000+',
        					'employees' => '10+',
        					'partners' => '10+'
        				]

    	];

    	$jsonPartners = [];

        $sectionCoverTrans = SectionTranslation::create([
        	'title' => 'Cover Photo',
        	'data' => $jsonCover,
        	'language_id' => $language->id,
        	'section_id' => $sectionCover->id
        ]);

        $sectionAboutTrans = SectionTranslation::create([
        	'title' => 'About',
        	'data' => $jsonAbout,
        	'language_id' => $language->id,
        	'section_id' => $sectionAbout->id
        ]);

        $sectionPartners = SectionTranslation::create([
        	'title' => 'Partners',
        	'data' => $jsonPartners,
        	'section_id' => $sectionPartners->id,
        	'language_id' => $language->id
        ]);
    }
}
