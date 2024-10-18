<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortenedResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            "created_at"=> $this->created_at->format('d-m-Y'),
            "shortened_url"=> url("/")."/".$this->shortened_url,
            "long_url"=> $this->long_url,
            "clicks"=> $this->clicks
        ];
    }
}
