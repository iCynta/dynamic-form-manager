<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DynamicFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DynamicFormDataController;

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
    Route::get('/dynamic-forms/{formId}/delete', [DynamicFormController::class, 'destroy'])->name('dynamic-forms.delete');
    Route::put('/dynamic-forms/{id}', [DynamicFormController::class, 'update'])->name('dynamic-forms.update');
    
    // Form Elements Actions
    Route::get('/dynamic-forms/{formId}/edit-field/{fieldKey}', [DynamicFormController::class, 'editField'])->name('dynamic-forms.edit-field');
    Route::delete('/dynamic-forms/{formId}/delete-field/{fieldKey}', [DynamicFormController::class, 'deleteField'])->name('dynamic-forms.delete-field');

    //Route to submit data with dynamic form
    Route::post('/submit-form', [DynamicFormDataController::class, 'store'])->name('submit-form');
    
    // Update dynamic form's form data
    Route::put('/dynamic-forms/{form}', [DynamicFormController::class, 'update'])->name('dynamic-forms.update');
    
    Route::get('/dynamic-forms/{form}', [DynamicFormController::class, 'show'])->name('dynamic-forms.show');

});

//Dynamic form public view 

// Include authentication routes (login, register, etc.) provided by Laravel
Auth::routes();

