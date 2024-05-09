<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    protected $fillable = ['form_name', 'form_fields'];
}
