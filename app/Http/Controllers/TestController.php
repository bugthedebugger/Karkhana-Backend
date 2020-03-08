<?php

namespace App\Http\Controllers;

use Storage;
use App\Model\Section;
use App\Model\SectionTranslation;
use App\Model\Blog;

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

        // // Storage::url('public/image');
        // // return Storage::files('public/images');
        // asset('public/images/Image112.png');

        // if(Storage::disk('local')->exists('public/images/Image112.png')){
        //     // return 'true';
        //     return Storage::disk('local')->url('public/images/Image112.png');
        // }

        // // $section = Section::where('code', 'landing_cover_photo')->first();
        // // // return $section;

        // // $translation = $section->translations()->where('language_id', 1)->first();

        // // // return $translation->resources;

        // // $resourcesCover = $translation->resources()->create([
        // //     'resource_type' => 'image',
        // //     'identifier' => 'slider',
        // //     'path'  => 'path',
        // //     'order' => 0
        // // ]); 
        $blog = Blog::first();
        return $blog->hasGuest();

    }
}
