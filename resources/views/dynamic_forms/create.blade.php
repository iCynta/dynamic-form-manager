<!-- resources/views/forms/create.blade.php -->

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
                    <div class="card-header">Create Dynamic Form</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dynamic-forms.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="form_name">Form Name</label>
                                <input type="text" id="form_name" name="form_name" class="form-control">
                            </div>

                            <div id="form_fields">
                                <!-- Dynamic fields will be added here -->
                            </div>

                            <button type="button" id="addFieldBtn" class="btn btn-sm btn-secondary">Add Field</button>
                            <button type="submit" class="btn btn-primary">Create Form</button>
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
            let fieldIndex = 1;

            addFieldBtn.addEventListener('click', function () {
                const fieldGroup = document.createElement('div');
                fieldGroup.className = 'form-group';

                const labelInput = document.createElement('input');
                labelInput.type = 'text';
                labelInput.name = `fields[${fieldIndex}][label]`;
                labelInput.placeholder = 'Label';
                labelInput.className = 'form-control';
                fieldGroup.appendChild(labelInput);

                const htmlFieldSelect = document.createElement('select');
                htmlFieldSelect.name = `fields[${fieldIndex}][html_field]`;
                htmlFieldSelect.className = 'form-control';
                htmlFieldSelect.innerHTML = `
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="select">Select</option>
                `;
                fieldGroup.appendChild(htmlFieldSelect);

                const helperTextInput = document.createElement('input');
                helperTextInput.type = 'text';
                helperTextInput.name = `fields[${fieldIndex}][helper_text]`;
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
                        addOptionBtn.className = 'btn btn-sm btn-secondary mt-2';
                        addOptionBtn.textContent = 'Add Option';
                        addOptionBtn.addEventListener('click', function () {
                            const optionItem = document.createElement('li');
                            const optionInput = document.createElement('input');
                            optionInput.type = 'text';
                            optionInput.name = `fields[${fieldIndex-1}][options][]`;
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
        });
    </script>
@endsection
