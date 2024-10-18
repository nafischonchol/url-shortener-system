<?php

namespace App\Services;

use App\Http\Resources\ShortenedResource;
use App\Models\ShortenUrl;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class URLShortenerService
{
    use ResponseTrait;

    private function getUserId($request)
    {
        $token = $request->bearerToken();
        if (!$token) 
            return null;

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) 
            return null;

        $user = $accessToken->tokenable;

        return $user->id;
    }

    public function shorten($request)
    {
        try
        {
            $url = ShortenUrl::create([
                "user_id" =>$this->getUserId($request),
                "long_url" => $request->url,
            ]);

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $base = 62;

            $id = $url->id;
            $shortened = '';
            while ($id > 0) {
                $shortened = $characters[$id % $base] . $shortened;
                $id = floor($id / $base);
            }

            $shortened_url = url('/') . "/" . $shortened;
            $url->update([
                "shortened_url" => $shortened,
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
                "meta" => $this->paginateMetaData($data, $request),
            ];

            return $this->responseSuccess($response);
        } catch (\Throwable $th) {
            return $this->responseError($th);
        }
    }

    public function redirectToOriginal($shortened)
    {
        try
        {
            $shortened_url = ShortenUrl::where('shortened_url', $shortened)->firstOrFail();

            $shortened_url->increment('clicks');

            return redirect($shortened_url->long_url);
        } catch (ModelNotFoundException $th) {
            return "Shortened URL not found";
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
