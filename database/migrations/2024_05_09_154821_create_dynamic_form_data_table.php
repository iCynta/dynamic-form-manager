<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicFormDataTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_form_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('dynamic_forms')->onDelete('cascade');
            $table->string('form_name');
            $table->json('form_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dynamic_form_data');
    }
}

