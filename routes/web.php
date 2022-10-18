<?php

use Illuminate\Support\Facades\Route;

Route::post('/line', "LineController@index")->name('line.index');