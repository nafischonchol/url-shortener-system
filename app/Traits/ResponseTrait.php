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

    function paginateMetaData($data, $request = null)
    {
        if ($request) {
            $data->appends($request->query());
        }

        $total_item = $data->total();
        $per_page = $data->perPage();
        $total_page = ceil($total_item / $per_page);

        return [
            'current_page' => $data->currentPage(), // Use currentPage() method
            'first_page_url' => $data->url(1),
            'last_page_url' => $data->url($data->lastPage()),
            'next_page_url' => $data->nextPageUrl(),
            'per_page' => $per_page,
            'total_item' => $total_item,
            'total_page' => $total_page,
        ];
    }
}
