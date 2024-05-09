<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicFormData extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'form_name', 'form_data'];

    protected $casts = [
        'form_data' => 'json',
    ];
}
