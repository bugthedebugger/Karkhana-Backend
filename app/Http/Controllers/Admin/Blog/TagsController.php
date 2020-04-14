<?php

namespace App\Http\Controllers\Admin\Blog;
use App\Http\Controllers\Controller;
use App\Model\Tag;
use App\Model\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Blog\TagsController as BaseTagsController;

class TagsController extends BaseTagsController
{
    /**
     * Function to store new Tag
     * @return json
     */
    public function store(Request $request) {
        $this->validate($request, [
            'tag' => 'required',
            'language' => 'required',
        ]);

        $language = Language::where('language', $request->language)->first();
        \DB::beginTransaction();
        try {
            $tag = Tag::create([]);
            $tag->translations()->create([
                'language_id' => $language->id,
                'name' => $request->tag,
            ]);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ],500);
        }
        return response()->json([
            'message' => 'Tag added successfully!',
            'status' => 'success',
        ]);
    }

    public function delete($tag) {
        $tag = Tag::find($tag);
        \DB::beginTransaction();
        try {
            $tag->blogs()->detach();
            $tag->delete();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ],500);
        }

        return response()->json([
            'message' => 'Tag deleted successfully!',
            'status' => 'success',
        ]);
    }
}
