<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PropertiesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 


Route::get('health', function () {
    return "OK";
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); 
 


Route::middleware('auth')->group(function () {
    Route::get('properties', [PropertiesController::class, 'index'])
                ->name('properties');
});

require __DIR__.'/auth.php';
