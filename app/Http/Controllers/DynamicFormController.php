<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DynamicForm;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendFormCreationNotification;

class DynamicFormController extends Controller
{
    public function index()
    {
        $forms = DynamicForm::all();
        return view('dynamic_forms.index', compact('forms'));
    }

//    public function create()
//    {
//        return view('dynamic_forms.create');
//    }
    
    public function view($formId)
    {
        try {
            $form = DynamicForm::findOrFail($formId);
            $fields = $form->fields; 
            return view('dynamic_forms/view', compact('form', 'fields'));
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Form not found!']);
        }
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
        $dynamic_form = new DynamicForm();
        $dynamic_form->form_name = $formName;
        $dynamic_form->form_fields = $formFieldsJson;

        // Save the DynamicForm instance
        $dynamic_form->save();
        // Dispatch the job to send email notification
        SendFormCreationNotification::dispatch($dynamic_form);

        return redirect()->back()->with('success', 'Form data stored successfully.');
    }
    
    public function edit($formId){
        
        try {            
            $form = DynamicForm::findOrFail($formId);
            $fields = json_decode($form->form_fields, true);
            return view('dynamic_forms.edit', compact('form', 'fields'));
            
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Form not found!']);
        }
    }
    
    public function update(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'form_name' => 'required|string',
            'fields' => 'required|array', // Ensure 'fields' is an array
        ]);

        // Retrieve the form from the database
        $form = DynamicForm::findOrFail($id);

        // Update the form name
        $form->form_name = $validatedData['form_name'];

        // Merge existing form fields with updated fields from the request
        $existingFields = json_decode($form->form_fields, true);
        $updatedFields = $validatedData['fields'];
        $mergedFields = array_merge($existingFields, $updatedFields);

        // Update form fields
        $form->form_fields = json_encode($mergedFields);

        // Save the updated form
        $form->save();

        // Redirect back to the form view with a success message
        return redirect()->route('dynamic-forms.edit', $id)->with('success', 'Form updated successfully');
    }


    
//    public function show(Form $form)
//    {
//        // Assuming you have a Form model and the $form parameter is automatically resolved based on the form ID in the URL
//        return view('dynamic_forms.show', compact('form'));
//    }
    
    public function showForm($formId)
    {       
        try {
            $form = DynamicForm::findOrFail($formId);
            $fields = $form->fields; 
            return view('dynamic_forms.show', compact('form', 'fields'));
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['message' => 'Form not found!']);
        }
    }
    
    public function destroy($formId)
    {
        $form = DynamicForm::findOrFail($formId);
        $form->delete();
        return redirect()->back()->with('success', 'Form deleted successfully.');
    }


}
