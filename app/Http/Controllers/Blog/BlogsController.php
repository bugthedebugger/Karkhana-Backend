<?php

namespace App\Http\Controllers\Blog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Language;
use Illuminate\Http\Request;
use Auth;
use Storage;

class BlogsController extends Controller
{
    protected $language = null;
    protected $showUnpublished = false;

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

        if($this->showUnpublished) {
            $blogs = Blog::orderBy('created_at', 'desc')->paginate($request->per_page);
        } else {
            $blogs = Blog::where('published', '=', true)->orderBy('created_at', 'desc')->paginate($request->per_page);
        }
        $blogList = [];
        
        foreach($blogs as $blog) {
            $translations = $blog->translations()->get();
            if (is_null($translations))
                continue;
            foreach($translations as $translated) {
                if(Storage::disk('s3')->exists($blog->featured))
                    $featuredImage = Storage::disk('s3')->url($blog->featured);
                else 
                    $featuredImage = null;

                $summary = substr(strip_tags($translated->body), 10, 150);

                $blogList[] = base64_encode(json_encode([
                    'uuid' => $translated->uuid,
                    'featured' => $featuredImage,
                    'author' => $blog->owner->name,
                    'title' => $translated->title,
                    'summary' => '... '.$summary.' ...',
                    'read_time' => $translated->read_time,
                    'created_at' => $translated->created_at,
                    'published' => $blog->published == 0 ? false: true,
                ]));
            }
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
        ],200, [
            'Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8',
        ]);
    }

    /**
     * Function to find BLOG by UUID
     * @return json
     */
    public function findByUUID($uuid) {

        if($this->showUnpublished) {
            $blog = Blog::where('uuid', $uuid)->first();
        } else {
            $blog = Blog::where([
                ['uuid', '=', $uuid],
                ['published', '=', true],
            ])->first();
        }

        if($blog) {
            $translated = $blog->translations()->first();
            $unFilteredTags = $blog->tags;
            $tags = null;
            
            foreach($unFilteredTags as $tag) {
                $translatedTag = $tag->translations()->first();
                $tags[] = [
                    'id' => $tag->id,
                    'name' => $translatedTag->name,
                ];
            }

            if(Storage::disk('s3')->exists($blog->featured))
                $featuredImage = Storage::disk('s3')->url($blog->featured);
            else 
                $featuredImage = null;

            $foundBlog = [
                'uuid' => $translated->uuid,
                'featured' => $featuredImage,
                'author' => $blog->owner->name,
                'title' => $translated->title,
                'body' => $translated->body,
                'language' => [
                    'name' => $translated->language->name,
                    'code' => $translated->language->language,
                ],
                'tags' => $tags,
                'read_time' => $translated->read_time . ' min',
                'created_at' => $translated->created_at,
                'published' => $blog->published == 0 ? false: true,
            ];
            return response()->json([
                'message' => 'Blog found',
                'status' => 'success',
                'data' => $foundBlog,
            ]);
        } else {
            return response()->json([
                'message' => 'Could not find blog.',
                'status' => 'error',
            ], 404);
        }
    }
}
