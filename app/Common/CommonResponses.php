<?php

/**
 *  Common class for responses
 */

namespace App\Common;

class CommonResponses {
    public static function exception($exception, $code=500) {
        \Log::error($exception);
        return response()->json([
            'status' => 'error',
            'message' => $exception->getMessage(),
        ], $code);
    }

    public static function error($message, $code=500) {
        \Log::error($message);
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    public static function success($message, $hasData=false, $data=null) {
        $body = [
            'status' => 'success',
            'message' => $message,
        ];

        if ($hasData) {
            $body['data'] = $data;
        }

        return response()->json($body, 200);
    }
}