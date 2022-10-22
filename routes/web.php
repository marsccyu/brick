<?php

use Illuminate\Support\Facades\Route;

// Line API Webhook
Route::post('/line', "LineController@index")->name('line.index');
Route::get('/info', "LineController@test")->name('line.test');
