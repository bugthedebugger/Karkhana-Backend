<?php

namespace App\Http\Controllers\Admin\Blog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Language;


class BlogsController extends Controller
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
     * Function to display the list of BLOGs
     * @return json
     */
    public function index() {
        $blogs = Blog::all();
        $blogList = [];
        
        foreach($blogs as $blog) {
            $blogList[] = $blog->translate($this->language)->first();
        }

        return response()->json([
            'message' => 'success',
            'data' => $blogList,
        ]);
    }

    /**
     * Function to create new BLOG
     * @return json
     */
    public function create() {
        $uuid = Str::uuid();

        \DB::beginTransaction();
        try {
            Blog::create([
                'uuid' => $uuid,
                'author' => 1, //TODO: Replace author with authenticated user.
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
            'message' => 'Blog created successfully!',
            'status' => 'success',
            'data' => [
                'blogID'=> $uuid,
            ],
        ]);
    }

    /**
     * Funciton to autosave the BLOG
     */

    public function update($uuid) {
        $blog = Blog::where('uuid', $uuid)->first();

        return response()->json($blog);
    }
}
