<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\URLShortenerController;

// can't find out better way to handle vue route here. 
Route::group(['middleware' => 'web'], function () {
    $paths = ['login', 'register']; 

    foreach ($paths as $path) {
        Route::get("/{$path}", function () {
            return view('app'); 
        });
    }
});


Route::get('/{shortened}', [URLShortenerController::class, 'redirectToOriginal'])
    ->where('shortened', '[A-Za-z0-9]+');
    
Route::get('/{any}', function () {
    return view('app'); 
})->where('any', '.*');
