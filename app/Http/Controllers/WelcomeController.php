<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicForm;

class WelcomeController extends Controller
{
    public function index(){
        $forms = DynamicForm::all();
        return view('welcome', compact('forms'));
    }
}
