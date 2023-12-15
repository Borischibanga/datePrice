<?php
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DateRangeController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('submit-form');
});
Route::get('/get-amounts', [CalendarController::class, 'getAmounts']);

Route::post('/submit-form', [DateRangeController::class, 'submitForm'])->name('submit-form');

Route::get('/your-view', [DateRangeController::class, 'yourView'])->name('your-view');
// routes/web.php

Route::get('/fetch-prices', [DateRangeController::class, 'fetchPrices']);
