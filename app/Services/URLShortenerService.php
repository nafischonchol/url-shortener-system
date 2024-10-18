<?php

namespace App\Services;

use App\Models\ShortenUrl;
use App\Traits\ResponseTrait;
use App\Http\Resources\ShortenedResource;

class URLShortenerService
{
    use ResponseTrait;
    public function shorten($request)
    {
        try
        {
            $url = ShortenUrl::create([
                "user_id"=> auth()->id(),
                "long_url" => $request->url
            ]);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $base = 62;

            $id = $url->id;
            $short_url = '';
            while ($id > 0) {
                $short_url = $characters[$id % $base] . $short_url;
                $id = floor($id / $base);
            }

            $shortened_url = url('/')."/".$short_url;
            $url->update([
                "shortened_url" => $shortened_url
            ]);

            return $this->responseSuccess($shortened_url);
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }
    
    public function getLinks($request)
    {
        try
        {
            $data = ShortenUrl::latest("id")
            ->where('user_id', auth()->id())
            ->paginate($request->input('per_page', 10));
          
            $response = [
                'links' => ShortenedResource::collection($data),
                "meta"=> $this->paginateMetaData($data, $request)
            ];

            return $this->responseSuccess($response);
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    public function redirectToOriginal()
    {
        try
        {
            redirect('fsdf');
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }
 
}
