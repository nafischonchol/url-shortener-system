<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

trait ResponseTrait
{
    public function responseSuccess($data, $message = null, $responseType = Response::HTTP_OK)
    {
        return response()->json([
            "success" => true,
            'item' => $data,
            "message" => $message,
        ], $responseType);
    }

    public function responseError($th = null, $message = null, $responseType = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        if (!$message) {
            $message = $th->getMessage();
        }
        if ($th) {
            Log::error($th);
        }

        return response()->json([
            "success" => false,
            "item" => null,
            "message" => $message,
        ], $responseType);
    }
}
