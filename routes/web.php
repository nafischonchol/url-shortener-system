<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\URLShortenerController;


Route::get('/{shortened}', [URLShortenerController::class, 'redirectToOriginal'])
    ->where('shortened', '[A-Za-z0-9]+');
    
Route::get('/{any}', function () {
    return view('app'); 
})->where('any', '.*');
