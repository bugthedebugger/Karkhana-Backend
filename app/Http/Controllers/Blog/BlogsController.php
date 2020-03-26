<?php

namespace App\Http\Controllers\Blog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Language;
use Illuminate\Http\Request;
use Auth;
use Storage;
use App\Common\CommonResponses;

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

                if ($blog->hasGuest()) {
                    $author = $blog->guest->info();
                } else {
                    if ($blog->owner->id != 1) {
                        $author = [
                            'id' => $blog->owner->id,
                            'name' => $blog->owner->name,
                            'avatar' => Storage::disk('s3')->url($blog->owner->info->avatar),
                            'bio' => $blog->owner->info->bio,
                            'facebook' => $blog->owner->info->facebook,
                            'linkedin' => $blog->owner->info->linkedin,
                            'twitter' => $blog->owner->info->twitter,
                            'youtube' => $blog->owner->info->youtube,
                            'instagram' => $blog->owner->info->instagram,
                        ];
                    } else {
                        $author = [
                            'id' => $blog->owner->id,
                            'name' => $blog->owner->name,
                            'avatar' => 'https://karkhana-website-bucket.s3-ap-southeast-1.amazonaws.com/head.png',
                        ];
                    }
                }

                $blogList[] = [
                    'uuid' => $translated->uuid,
                    'slug' => $blog->slug,
                    'featured' => $featuredImage,
                    'author' => $author,
                    'title' => utf8_encode($translated->title),
                    'summary' => utf8_encode($summary),
                    'read_time' => $translated->read_time,
                    'created_at' => $translated->created_at,
                    'published' => $blog->published == 0 ? false: true,
                    'guest' => $blog->hasGuest(),
                ];
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
            if (is_null($blog)) {
                $blog = Blog::where('slug', 'like', $uuid)->first();
            }
        } else {
            $blog = Blog::where([
                ['uuid', '=', $uuid],
                ['published', '=', true],
            ])->first();
            if (is_null($blog)) {
                $blog = Blog::where([
                    ['slug', 'like', $uuid],
                    ['published', '=', true],
                ])->first();
            }
        }

        if ($blog) {
            $requestedBlog = $this->getBlogData($blog, true);

            $nextBlogRaw = Blog::where('id', '>', $blog->id)->min('id');
            $previousBlogRaw = Blog::where('id', '<', $blog->id)->max('id');

            if($nextBlogRaw) {
                $nextBlog = $this->getBlogData(Blog::find($nextBlogRaw));
            } else {
                $nextBlog = null;
            }

            if($previousBlogRaw) {
                $previousBlog = $this->getBlogData(Blog::find($previousBlogRaw));
            } else {
                $previousBlog = null;
            }

            $requestedBlog['next'] = $nextBlog;
            $requestedBlog['previous'] = $previousBlog;

            return CommonResponses::success('success', true, $requestedBlog);
        } else {
            return CommonResponses::error('Could not find blog', 404);
        }
    }

    protected function getBlogData(Blog $blog, $includeBody=false) {
        if($blog) {
            if(!$this->showUnpublished && !$blog->published)
                return null;

            $translated = $blog->translations()->first();
            $unFilteredTags = $blog->tags;
            $tags = null;

            if ($blog->hasGuest()) {
                $author = $blog->guest->info();
            } else {
                if ($blog->owner->id != 1) {
                    $author = [
                        'id' => $blog->owner->id,
                        'name' => $blog->owner->name,
                        'avatar' => Storage::disk('s3')->url($blog->owner->info->avatar),
                        'bio' => $blog->owner->info->bio,
                        'facebook' => $blog->owner->info->facebook,
                        'linkedin' => $blog->owner->info->linkedin,
                        'twitter' => $blog->owner->info->twitter,
                        'youtube' => $blog->owner->info->youtube,
                        'instagram' => $blog->owner->info->instagram,
                    ];
                } else {
                    $author = [
                        'id' => $blog->owner->id,
                        'name' => $blog->owner->name,
                        'avatar' => 'https://karkhana-website-bucket.s3-ap-southeast-1.amazonaws.com/head.png',
                    ];
                }
            }
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
                'slug' => $blog->slug,
                'featured' => $featuredImage,
                'author' => $author,
                'title' => $translated->title,
                'language' => [
                    'name' => $translated->language->name,
                    'code' => $translated->language->language,
                ],
                'tags' => $tags,
                'read_time' => $translated->read_time . ' min',
                'created_at' => $translated->created_at,
                'published' => $blog->published == 0 ? false: true,
                'guest' => $blog->hasGuest(),
            ];

            if ($includeBody)
                $foundBlog['body'] = $translated->body;
            return $foundBlog;
        } else {
            return null;
        }
    }
}

