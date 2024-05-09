<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicFormData; // Assuming you have a model named DynamicFormData

class DynamicFormDataController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming form data
        $validatedData = $request->validate([
            'form_id' => 'required|integer',
            'form_name' => 'required|string',
            'fields' => 'required|array',
        ]);

        // Store the form data in the database
        $formData = new DynamicFormData();
        $formData->form_id = $validatedData['form_id'];
        $formData->form_name = $validatedData['form_name'];
        $formData->form_data = json_encode($validatedData['fields']);
        $formData->save();

        // Retrieve the submitted form data
        $submittedFormData = [
            'form_id' => $formData->form_id,
            'form_name' => $formData->form_name,
            'form_data' => json_decode($formData->form_data, true),
        ];

        // Redirect back or to a success page, passing the form data and success message
        return redirect()->route('dynamic-forms.view', $formData->form_id)
                         ->with('success', 'Form data submitted successfully.')
                         ->with('form_fields', $submittedFormData);
    }


}
