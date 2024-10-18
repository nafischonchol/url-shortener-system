<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Services\URLShortenerService;
use Illuminate\Http\Request;

class URLShortenerController extends Controller
{
    public function __construct(private URLShortenerService $urlShortenerService){}

    public function shorten(ShortenRequest $request)
    {
        return $this->urlShortenerService->shorten($request);
    }

    public function getLinks(Request $request)
    {
        return $this->urlShortenerService->getLinks($request);
    }
    
    public function redirectToOriginal(Request $request)
    {
        return "fhslfsdf";
    }
}
