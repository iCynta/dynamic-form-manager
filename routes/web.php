<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DynamicFormController;
use App\Http\Controllers\HomeController;

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/home', function () {
//    return view('home');
//});
//
//
//Auth::routes();
//
////Route::get('/dynamic-forms/create', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/dynamic-forms/create', function () {
//    return view('dynamic_forms.create');
//})->name('create-new-form');
//
//Route::post('/dynamic-forms/store', [DynamicFormController::class, 'store'])->name('dynamic-forms.store');
//


// Define your non-authenticated routes outside the group
Route::get('/', function () {
    return view('welcome');
});

// Create the 'auth' route group
Route::middleware(['auth'])->group(function () {
    // Define your restricted routes inside this group
//    Route::get('/home', function () {
//        return view('home');
//    })->name('home');
    
    
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/dynamic-forms/create', function () {
        return view('dynamic_forms.create');
    })->name('create-new-form');

    Route::post('/dynamic-forms/store', [DynamicFormController::class, 'store'])->name('dynamic-forms.store');

    // Add more restricted routes as needed
});

// Include authentication routes (login, register, etc.) provided by Laravel
Auth::routes();

