<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicForm;
use Illuminate\Support\Facades\Validator;

class DynamicFormController extends Controller
{
    public function index()
    {
        $forms = DynamicForm::all();
        return view('dynamic_forms.index', compact('forms'));
    }

    public function create()
    {
        return view('dynamic_forms.create');
    }
    
    public function view(Request $request)
    {
        $formId = $request->id;
        $form = DynamicForm::findOrFail($id); // Find the form by ID
        $fields = $form->fields; // Assuming 'fields' is a JSON string or array within the model
        return view('dynamic_forms/view', compact('form', 'fields')); // Pass data to the view

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_name' => 'required|string|unique:dynamic_forms,form_name',
            'fields' => 'required|array|min:1',
            'fields.*.label' => 'required|string',
            'fields.*.html_field' => 'required|string|in:text,number,select',
            'fields.*.helper_text' => 'nullable|string',
            'fields.*.options' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    if (request()->input("fields.*.html_field") == "select" && empty($value)) {
                        $fail("The $attribute field is required for select boxes.");
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the form name
        $formName = $request->input('form_name');

        // Prepare the form fields data
        $formFields = [];
        foreach ($request->input('fields') as $fieldData) {
            $fieldLabel = $fieldData['label'];
            $htmlField = $fieldData['html_field'];
            $options = $fieldData['options'] ?? null; // If HTML field type is not "select", options will be null
            $helperText = $fieldData['helper_text'] ?? null; // Helper text is optional

            // Create a new field data structure
            $newField = [
                'label' => $fieldLabel,
                'html_field' => $htmlField,
                'options' => $options,
                'helper_text' => $helperText,
            ];

            $formFields[] = $newField;
        }

        // Encode the form fields array to JSON before saving
        $formFieldsJson = json_encode($formFields);

        // Create a new instance of DynamicForm (assuming logic remains the same)
        $field = new DynamicForm();
        $field->form_name = $formName;
        $field->form_fields = $formFieldsJson;

        // Save the DynamicForm instance
        $field->save();

        return redirect()->back()->with('success', 'Form data stored successfully.');
    }


}
