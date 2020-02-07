<?php

namespace App\Http\Controllers\Blog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Language;
use Illuminate\Http\Request;
use Auth;


class BlogsController extends Controller
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
     * Function to display the list of BLOGs
     * @return json
     */
    public function index(Request $request) {
        $this->validate($request, [
            'per_page' => 'required',
        ]);

        $blogs = Blog::paginate($request->per_page);
        $blogList = [];
        
        foreach($blogs as $blog) {
            $translated = $blog->translations()->first();
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

        $blogs = collect($blogs);

        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $blogList,
            "first_page_url" =>  $blogs['first_page_url'],
            "from" =>  $blogs['from'],
            "last_page" =>  $blogs['last_page'],
            "last_page_url" =>  $blogs['last_page_url'],
            "next_page_url" =>  $blogs['next_page_url'],
            "path" => $blogs['path'],
            "per_page" => $blogs['per_page'],
            "prev_page_url" => $blogs['prev_page_url'],
            "to" => $blogs['to'],
            "total" => $blogs['total'],
        ]);
    }

    /**
     * Function to find BLOG by UUID
     * @return json
     */
    public function findByUUID($uuid) {
        $blog = Blog::where('uuid', $uuid)->first();
        if($blog) {
            // TODO: Return the blog
        } else {
            return response()->json([
                'message' => 'Could not find blog.',
                'status' => error,
                'data' => $blogList,
            ], 404);
        }
    }
}
