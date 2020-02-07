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
