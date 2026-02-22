<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome'); // یا home
});

// Installer
Route::middleware('install.check')->group(function () {
    Route::get('/install', [InstallController::class, 'index'])->name('install.index');
    Route::post('/install/db', [InstallController::class, 'storeDb'])->name('install.db');
    Route::post('/install/finish', [InstallController::class, 'finish'])->name('install.finish');

    Route::get('/forms/{slug}', [\App\Http\Controllers\Site\FormFrontendController::class, 'show'])
        ->name('site.forms.show');

    Route::post('/forms/{slug}', [\App\Http\Controllers\Site\FormFrontendController::class, 'submit'])
        ->name('site.forms.submit');

    Route::get('/my/forms', [\App\Http\Controllers\Site\FormFrontendController::class, 'index'])
        ->name('site.forms.index');
});
