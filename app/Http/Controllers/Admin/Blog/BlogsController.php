<?php

namespace App\Http\Controllers\Admin\Blog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Language;
use Illuminate\Http\Request;
use Auth;


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
            $translated = $blog->translate($this->language)->first();
            if (is_null($translated))
                continue;
            $blogList[] = [
                'uuid' => $translated->uuid,
                'featured' => $blog->featured,
                'author' => $blog->owner->name,
                'title' => $translated->title,
                'read_time' => $translated->read_time,
                'created_at' => $translated->created_at,
                'published' => $blog->published == 0 ? false: true,
            ];
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
    public function create(Request $request) {
        $this->validate($request, [
            'title' => 'required',
        ]);
        
        $uuid = Str::uuid();
        $user = Auth::user();

        \DB::beginTransaction();
        try {
            $blog = Blog::create([
                'uuid' => $uuid,
                'author' => $user->id, 
            ]);
            $blog->translations()->create([
                'title' => $request->title,
                'language_id' => $this->language->id,
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
                'uuid'=> $uuid,
            ],
        ]);
    }

    /**
     * Funciton to autosave the BLOG
     */

    public function update(Request $request, $uuid) {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $blog = Blog::where('uuid', $uuid)->first();
        $translation = $blog->translation($this->language)->first();


        return response()->json($blog);
    }

    /**
     * AWS S3 only provides fully qulaified url if temporaryURL is used like this: 
     * Storage::disk('s3')->temporaryURL('images/3b8ad2c7b1be2caf24321c852103598a.jpg', \Carbon\Carbon::now()->addMinutes(15));
     */
}
