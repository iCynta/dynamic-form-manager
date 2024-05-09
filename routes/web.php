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
    
    
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/dynamic-forms/create', function () {
        return view('dynamic_forms.create');
    })->name('create-new-form');

    Route::post('/dynamic-forms/store', [DynamicFormController::class, 'store'])->name('dynamic-forms.store');
    Route::get('/dynamic-forms/{formId}/view', [DynamicFormController::class, 'view'])->name('dynamic-forms.view');
    Route::get('/dynamic-forms/{formId}/edit', [DynamicFormController::class, 'view'])->name('dynamic-forms.edit');
    Route::get('/dynamic-forms/{formId}/delete', [DynamicFormController::class, 'view'])->name('dynamic-forms.delete');
    Route::put('/dynamic-forms/{id}', [DynamicFormController::class, 'update'])->name('dynamic-forms.update');
    
    // Form Elements Actions
    Route::get('/dynamic-forms/{formId}/edit-field/{fieldKey}', [DynamicFormController::class, 'editField'])->name('dynamic-forms.edit-field');
    Route::delete('/dynamic-forms/{formId}/delete-field/{fieldKey}', [DynamicFormController::class, 'deleteField'])->name('dynamic-forms.delete-field');


});

// Include authentication routes (login, register, etc.) provided by Laravel
Auth::routes();

