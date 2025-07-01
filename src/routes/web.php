<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Tambahkan ini untuk route download file dokumen:
Route::get('/dokumen/download/{filename}', function ($filename) {
    $path = storage_path('app/protected_files/' . $filename);
    abort_if(!file_exists($path), 404);

    return response()->download($path);
})->name('dokumen.download')->middleware('auth');