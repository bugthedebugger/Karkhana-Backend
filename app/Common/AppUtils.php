<?php

namespace App\Common;
use Storage;

class AppUtils {
    static public function pathToAWSUrl($path) {
        if(Storage::disk('s3')->exists($path))
            $url = Storage::disk('s3')->url($path);
        else 
            $url = null;
        
        return $url;
    }
}