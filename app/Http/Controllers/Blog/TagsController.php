<?php

namespace App\Http\Controllers\Blog;
use App\Http\Controllers\Controller;
use App\Model\Tag;
use App\Model\Language;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    protected $language = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->language = Language::where('language', 'en')->first();
    }

    /**
     * Function to display the list of Tags
     * @return json
     */
    public function index() {
        $tags = Tag::all();
        $tagList = [];
        foreach($tags as $tag) {
            $tagList[] = $tag->translate($this->language)->first();
        }
        return response()->json([
            'message' => 'success',
            'data' => $tagList,
        ]);
    }
}
