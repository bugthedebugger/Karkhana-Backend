<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\AppUtils;
use App\Model\Resource;
use App\Model\Page;

class ResourcesController extends Controller
{
    public function upload(Request $request) {
        $this->validate($request, [
            'media' => 'required|max:81920',
            'page_code' => 'required|string',
        ]); 

        $page = Page::where('code', $request->page_code)->first();

        if($page) {
            $path = 'resources';
            \DB::beginTransaction();
            try {
                $identifier = Str::uuid();
                $resource_type = $request->type;
                $media = $request->media;
                $media_path = $request->media->store($path, 's3');

                Resource::create([
                    'resourceable_id' => -1, 
                    'resourceable_type' => $page->code, 
                    'resource_type' => $request->media->getMimeType(), 
                    'identifier' => $identifier, 
                    'order' => 0, 
                    'path' => $media_path,
                ]);

                \DB::commit();       
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);    
            }
            $data = [
                'path' => $media_path,
                'url' => AppUtils::pathToAWSUrl($media_path),
            ];
            return CommonResponses::success('Media uploaded successfully!', true, $data);
        }

        return CommonResponses::error('Invalid page code!', 422);
    }

    public function listResourceByIdentifier($code) {
        $page = Page::where('code', $code)->first();
        
        if($page) {
            $resources = Resource::where('resourceable_type', $page->code)->get();
            $resourceList = null;
            foreach($resources as $resource) {
                $resourceList[] = [
                    'path' => $resource->path,
                    'url' => AppUtils::pathToAWSUrl($resource->path),
                    'page_code' => $resource->resourceable_type,
                    'resource_type' => $resource->resource_type,
                ];
            }
            return CommonResponses::success('success', true, $resourceList);
        }
        return CommonResponses::error('Inavlid page code!', 422);
    }

    public function allResources() {
        $resources = Resource::all();
        $resourceList = null;

        try {
            foreach($resources as $resource) {
                $resourceList[] = [
                    'path' => $resource->path,
                    'url' => AppUtils::pathToAWSUrl($resource->path),
                    'page_code' => $resource->resourceable_type,
                    'resource_type' => $resource->resource_type,
                ];
            }
        } catch(\Exception $e) {
            return CommonResponses::exception($e);
        }
        return CommonResponses::success('success', true, $resourceList);
    }
}
