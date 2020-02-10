<?php

namespace App\Http\Controllers\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Gallery;
use Storage;

class GalleryController extends Controller
{

    public function getGallery($uuid) {
        $gallery = Gallery::where('uuid', $uuid)->get();
        $imageList = null;

        foreach($gallery as $galleryImage) {
            $imageList[] = [
                'path' => $galleryImage->path,
                'url' => Storage::disk('s3')->url($galleryImage->path),
            ];
        }

        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $imageList,
        ]);
    }
}
