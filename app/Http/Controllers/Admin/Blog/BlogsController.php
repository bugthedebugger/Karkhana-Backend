<?php

namespace App\Http\Controllers\Admin\Blog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Language;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Blog\BlogsController as BaseBlogsController;

class BlogsController extends BaseBlogsController
{

    public function __construct() {
        $this->showUnpublished = true;
        $this->language = Language::where('language', 'en')->first();
    }

    public function getUUID() {
        $uuid = Str::uuid();

        return response()->json([
            'message' => 'UUID generated successfully!',
            'status' => 'success',
            'data' => [
                'uuid'=> $uuid,
            ],
        ]);
    }

    /**
     * Function to create new BLOG
     * @return json
     */
    public function create(Request $request) {
        $this->validate($request, [
            'uuid' => 'required',
            'title' => 'required',
            'language' => 'required',
        ]);

        $slug = Str::slug($request->slug);    
        $searchForSlug = true;
        
        if (is_null($slug) || $slug == '' || $slug == null || $slug == 'null') {
            $searchForSlug = false;
            $slug = null;
        }
        
        $uuid = $request->uuid;
        $author = $request->author;
        if ($author) {
            if ($author != 'null') {
                $user = User::find($author);
            }
        } else {
            $user = Auth::user();
        }
        $tags = $request->tags;
        $language = Language::where('language', $request->language)->first();

        \DB::beginTransaction();
        try {
            $blog = Blog::where('uuid', $uuid)->first();
            
            if ($blog) {
                if ($blog->slug != $slug && $searchForSlug) {
                    $slugCount = Blog::where([
                        ['slug', 'like', $slug],
                        ['uuid', '!=', $uuid]
                    ])->get()->count();

                    if ($slugCount > 0) {
                        return response()->json([
                            'message' => 'Slug already in use.',
                            'status' => 'error',
                        ], 500);
                    }
                }

                $blog->author = $user->id;
                if ($searchForSlug)
                    $blog->slug = $slug;
                if($request->featured) {
                    if($request->featured != 'null') {
                        $blog->featured = $request->featured;
                    }
                } 
                $blog->save();
            } else {
                if ($searchForSlug) {
                    $slugCount = Blog::where([
                        ['slug', 'like', $slug],
                    ])->get()->count();

                    if ($slugCount > 0) {
                        return response()->json([
                            'message' => 'Slug already in use.',
                            'status' => 'error',
                        ], 500);
                    }
                }

                $blog = Blog::create([
                    'uuid' => $uuid,
                    'slug' => $slug,
                    'author' => $user->id,
                    'featured' => $request->featured,
                ]);
            }

            $blog->tags()->sync($tags);

            $translation = $blog->translations()->where('language_id', $language->id)->first();
            if($translation) {
                $translation->update([
                    'language_id' => $language->id,
                    'title' => $request->title,
                    'body' => $request->body,
                    'read_time' => round(strlen(strip_tags($request->body))/200),
                ]);
            } else {
                $blog->translations()->create([
                    'language_id' => $language->id,
                    'title' => $request->title,
                    'body' => $request->body,
                    'read_time' => round(strlen(strip_tags($request->body))/200),
                ]);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }

        return response()->json([
            'message' => 'Blog created/updated successfully!',
            'status' => 'success',
            'data' => [
                'uuid' => $uuid,
                'slug' => $blog->slug,
            ],
        ]);
    }

    public function publish($uuid) {
        $blog = Blog::where('uuid', $uuid)->first();

        if($blog) {
            \DB::beginTransaction();
            try {
                $blog->published = true;
                $blog->save();
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                \Log::error($e);
                return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 'error',
                ], 500);
            }
            return response()->json([
                'message' => 'Blog published successfully!',
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'Could not find blog.',
                'status' => 'error',
            ], 404);
        }
    }

    public function delete($uuid) {
        $blog = Blog::where('uuid', $uuid)->first();
        \DB::beginTransaction();
        try {
            $blog->delete();
            \DB::commit();
        } catch(\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }

        return response()->json([
            'message' => 'Blog deleted successfully!',
            'status' => 'success',
        ]);
    }

    public function unPublish($uuid) {
        $blog = Blog::where('uuid', $uuid)->first();

        if($blog) {
            \DB::beginTransaction();
            try {
                $blog->published = false;
                $blog->save();
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                \Log::error($e);
                return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 'error',
                ], 500);
            }
            return response()->json([
                'message' => 'Blog unpublished successfully!',
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'Could not find blog.',
                'status' => 'error',
            ], 404);
        }
    }
}
