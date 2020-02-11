<?php

namespace App\Http\Controllers;

use Storage;
use App\Model\Section;
use App\Model\SectionTranslation;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test(){

        Storage::disk('s3')->put('pages/image/test.txt', 'tests');
        return Storage::disk('s3')->url('pages/image/test.txt');
        // return Storage::files('public/images');
        // asset('public/images/Image112.png');

        if(Storage::disk('s3')->exists('pages/images/Image112.png')){
            return Storage::disk('local')->url('public/images/Image112.png');
        }

        // $section = Section::where('code', 'landing_cover_photo')->first();
        // // return $section;

        // $translation = $section->translations()->where('language_id', 1)->first();

        // // return $translation->resources;

        // $resourcesCover = $translation->resources()->create([
        //     'resource_type' => 'image',
        //     'identifier' => 'slider',
        //     'path'  => 'path',
        //     'order' => 0
        // ]); 

        return 'ok';

    }
}
