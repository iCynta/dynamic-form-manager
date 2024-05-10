@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        Edit {{ $form->form_name }}
                        <a href='{{ route('dashboard') }}' class='btn btn-sm btn-primary float-end'>Available Form List</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dynamic-forms.update', $form->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="form_name">Form Name</label>
                                <input type="text" id="form_name" name="form_name" class="form-control" value="{{ $form->form_name }}">
                            </div>
                            <div id="form_fields">
                                @if (!empty($form->form_fields))
                                    @foreach(json_decode($form->form_fields, true) as $key => $field)
                                        <div class="form-group">
                                            @if(is_array($field))
                                                @if(isset($field['label']))
                                                    <label for="{{ $key }}" class="form-label">{{ $field['label'] }}</label>
                                                    @if($field['html_field'] === 'text')
                                                        <input type="text" name="{{ $key }}" value="{{ old($key) }}" class="form-control">
                                                    @elseif($field['html_field'] === 'select')
                                                        <select name="{{ $key }}" class="form-control">
                                                            @foreach($field['options'] as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-sm btn-secondary mt-2 add-option">Add Option</button>
                                                        <ul class="list-unstyled">
                                                            <!-- Existing options -->
                                                            @foreach($field['options'] as $option)
                                                                <li>
                                                                    <input type="text" name="{{ $key }}_options[]" value="{{ $option }}" class="form-control option-input" readonly>
                                                                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-option">Remove</button>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <small>{{ $field['helper_text'] }}</small>
                                                @endif
                                            @elseif(is_object($field))
                                                @if(isset($field->label))
                                                    <label class="form-label">{{ $field->label }}</label>
                                                    @if($field->html_field === 'text')
                                                        <input type="text" name="{{ $key }}" value="{{ old($key) }}" class="form-control">
                                                    @elseif($field->html_field === 'select')
                                                        <select name="{{ $key }}" class="form-control">
                                                            @foreach($field->options as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-sm btn-secondary mt-2 add-option">Add Option</button>
                                                        <ul class="list-unstyled">
                                                            <!-- Existing options -->
                                                            @foreach($field->options as $option)
                                                                <li class="option-item">
            <div class="option-input-container ">
                <input type="text" name="{{ $key }}_options[]" value="{{ $option }}" class="form-control option-input" readonly>
            </div>
            <button type="button" class="btn btn-sm btn-danger m-2 remove-option">Remove</button>
        </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <small>{{ $field->helper_text }}</small>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <br/>
                                <button type="button" id="addFieldBtn" class="btn btn-sm btn-secondary">Add Field</button>
                                <button type="submit" class="btn btn-success float-end">Update Form</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .option-input {
            width: calc(100% - 90px);
            margin-right: 10px;
        }

        .remove-option {
            margin-left: 10px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formFieldsContainer = document.getElementById('form_fields');
            const addFieldBtn = document.getElementById('addFieldBtn');
            let fieldIndex = {{ count(json_decode($form->form_fields, true)) }};

            addFieldBtn.addEventListener('click', function () {
                // Your existing code to add new form fields
            });

            // Function to handle adding options to a select field
            function addOption(selectElement) {
                const optionsList = selectElement.parentNode.querySelector('ul');
                const optionItem = document.createElement('li');
                const optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.name = `fields[new_${fieldIndex-1}][options][]`;
                optionInput.placeholder = 'Option';
                optionInput.className = 'form-control mt-2 option-input';
                optionItem.appendChild(optionInput);
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-sm btn-danger mt-2 remove-option';
                removeButton.textContent = 'Remove';
                optionItem.appendChild(removeButton);
                optionsList.appendChild(optionItem);
            }

            // Function to handle removing options from a select field
            function removeOption(optionElement) {
                optionElement.parentNode.removeChild(optionElement);
            }

            // Event delegation for dynamically added option buttons
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('add-option')) {
                    addOption(e.target);
                } else if (e.target.classList.contains('remove-option')) {
                    removeOption(e.target.parentNode);
                }
            });
        });
    </script>
@endsection
