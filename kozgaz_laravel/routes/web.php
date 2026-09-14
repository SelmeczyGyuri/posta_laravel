<?php

use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CountiesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cities', CitiesController::class);

Route::resource('counties', CountiesController::class);
