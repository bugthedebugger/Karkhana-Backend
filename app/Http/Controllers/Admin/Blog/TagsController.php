<?php

namespace App\Http\Controllers\Admin\Blog;
use App\Http\Controllers\Controller;
use App\Model\Tag;
use App\Model\Language;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    private $language = null;
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
            $tagList[] = $tag->translate($this->language);
        }
        return $tagList;
    }

    /**
     * Function to store new Tag
     * @return json
     */
    public function store(Request $request) {
        \DB::beginTransaction();
        try {
            $tag = Tag::create([]);
            $tag->translations()->create([
                'language_id' => $this->language->id,
                'name' => $request->tag,
            ]);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ]);
        }
        return response()->json([
            'message' => 'Tag added successfully!',
            'status' => 'success',
        ]);
    }
}
