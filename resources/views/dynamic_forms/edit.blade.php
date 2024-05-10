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
                        Edit {{$form->form_name }}
                        <a href='{{route('dashboard')}}' class='btn btn-sm btn-primary float-end'>Available Form List</a>
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
                                                    @endif
                                                    <small>{{ $field['helper_text'] }}</small>
                                                @endif
                                            @elseif(is_object($field))
                                                @if(isset($field->label))
                                                    <label class="form-label" >{{ $field->label }}</label>
                                                    @if($field->html_field === 'text')
                                                        <input type="text" name="{{ $key }}" value="{{ old($key) }}" class="form-control">
                                                    @elseif($field->html_field === 'select')
                                                        <select name="{{ $key }}" class="form-control">
                                                            @foreach($field->options as $option)
                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                            @endforeach
                                                        </select>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formFieldsContainer = document.getElementById('form_fields');
            const addFieldBtn = document.getElementById('addFieldBtn');
            let fieldIndex = {{ count(json_decode($form->form_fields, true)) }};

            addFieldBtn.addEventListener('click', function () {
                const fieldGroup = document.createElement('div');
                fieldGroup.className = 'form-group mt-4';

                const labelInput = document.createElement('input');
                labelInput.type = 'text';
                labelInput.name = `fields[new_${fieldIndex}][label]`;
                labelInput.placeholder = 'Label';
                labelInput.className = 'form-control mt-2';
                fieldGroup.appendChild(labelInput);

                const htmlFieldSelect = document.createElement('select');
                htmlFieldSelect.name = `fields[new_${fieldIndex}][html_field]`;
                htmlFieldSelect.className = 'form-control mt-2';
                htmlFieldSelect.innerHTML = `
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="select">Select</option>
                `;
                fieldGroup.appendChild(htmlFieldSelect);

                const helperTextInput = document.createElement('input');
                helperTextInput.type = 'text';
                helperTextInput.name = `fields[new_${fieldIndex}][helper_text]`;
                helperTextInput.placeholder = 'Helper Text';
                helperTextInput.className = 'form-control mt-2';
                fieldGroup.appendChild(helperTextInput);

                htmlFieldSelect.addEventListener('change', function () {
                    if (this.value === 'select') {
                        const optionsContainer = document.createElement('div');
                        optionsContainer.className = 'form-group';

                        const optionsLabel = document.createElement('label');
                        optionsLabel.textContent = 'Options';
                        optionsContainer.appendChild(optionsLabel);

                        const optionsList = document.createElement('ul');
                        optionsList.className = 'list-unstyled';
                        optionsContainer.appendChild(optionsList);

                        const addOptionBtn = document.createElement('button');
                        addOptionBtn.type = 'button';
                        addOptionBtn.className = 'btn btn-sm btn-secondary mt-2 add-option';
                        addOptionBtn.textContent = 'Add Option';
                        addOptionBtn.addEventListener('click', function () {
                            const optionItem = document.createElement('li');
                            const optionInput = document.createElement('input');
                            optionInput.type = 'text';
                            optionInput.name = `fields[new_${fieldIndex}][options][]`;
                            optionInput.placeholder = 'Option';
                            optionInput.className = 'form-control mt-2';
                            optionItem.appendChild(optionInput);
                            optionsList.appendChild(optionItem);
                        });
                        optionsContainer.appendChild(addOptionBtn);

                        fieldGroup.appendChild(optionsContainer);
                    }
                });

                formFieldsContainer.appendChild(fieldGroup);
                fieldIndex++;
            });

            // Add click event listener for dynamically added option buttons
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('add-option')) {
                    const optionsList = e.target.parentNode.querySelector('ul');
                    const optionItem = document.createElement('li');
                    const optionInput = document.createElement('input');
                    optionInput.type = 'text';
                    optionInput.name = `fields[new_${fieldIndex-1}][options][]`;
                    optionInput.placeholder = 'Option';
                    optionInput.className = 'form-control mt-2';
                    optionItem.appendChild(optionInput);
                    optionsList.appendChild(optionItem);
                }
            });
        });
    </script>
@endsection
