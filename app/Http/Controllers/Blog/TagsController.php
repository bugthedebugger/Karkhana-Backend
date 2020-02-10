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
    public function index(Request $request) {
        $this->validate($request, [
            'per_page' => 'required',
        ]);
        $tags = Tag::paginate($request->per_page);
        $tagList = [];
        foreach($tags as $tag) {
            $translated = $tag->translations()->first();
            $tagList[] = [
                'id' => $translated->id,
                'name' => $translated->name,
            ];
        }

        $tags = collect($tags);
        return response()->json([
            'message' => 'success',
            'data' => $tagList,
            'first_page_url' => $tags['first_page_url'],
            'from' => $tags['from'],
            'last_page' => $tags['last_page'],
            'last_page_url' => $tags['last_page_url'],
            'next_page_url' => $tags['next_page_url'],
            'path' => $tags['path'],
            'per_page' => $tags['per_page'],
            'prev_page_url' => $tags['prev_page_url'],
            'to' => $tags['to'],
            'total' => $tags['total'],
        ]);
    }
}
