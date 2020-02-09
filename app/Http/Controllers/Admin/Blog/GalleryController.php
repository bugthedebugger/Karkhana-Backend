<?php

namespace App\Http\Controllers\Admin\Blog;
use Illuminate\Http\Request;
use App\Model\Gallery;
use App\Http\Controllers\Blog\GalleryController as BaseGalleryController;
use Storage;

class GalleryController extends BaseGalleryController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function upload(Request $request, $uuid) {
        $this->validate($request, [
            'photos' => 'required|array',
            'photos.*' => 'mimes:jpeg,jpg,png,gif,svg',
        ]);

        $filePath = 'images/gallery/'.$uuid;

        $photos = $request->photos;
        \DB::beginTransaction();
        try {
            foreach ($photos as $photo) {
                $saved = $photo->store($filePath, 's3');
                Gallery::create([
                    'uuid' => $uuid,
                    'media_type' => 'image',
                    'path' => $saved,
                ]);
            }
            \DB::commit();
        } catch(\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage,
                'status' => 'error',
            ], 500);;
        }

        return response()->json([
            'message' => 'File(s) uploaded successfully!',
            'status' => 'success',
        ]);
    }

    public function delete(Request $request, $uuid) {
        $this->validate($request, [
            'photos' => 'required|array',
            'photos.*' => 'string',
        ]);

        $photos = $request->photos;

        \DB::beginTransaction();
        try {
            foreach($photos as $photo) {
                $gallery = Gallery::where([
                    ['uuid', '=', $uuid],
                    ['path', '=', $photo]
                ])->first();
                if(Storage::disk('s3')->delete($photo)) {
                    $gallery->delete();
                }
            } 
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return response()->json([
                'message' => $e->getMessage,
                'status' => 'error',
            ], 500);;
        }

        return response()->json([
            'message' => 'File(s) deleted successfully!',
            'status' => 'success',
        ]);
    }
}
