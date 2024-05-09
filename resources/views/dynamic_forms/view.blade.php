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
                
                <div class='row'>
                    <div class='col-md-12 pb-2'>
                    <a href='{{route('dashboard')}}' class='btn btn-sm btn-primary float-end'>Back to Form List </a>
                    </div>
                </div>
                <div class="card">                    
                    <div class="card-header">{{ $form->form_name }}</div>
                    <div class="card-body">
                @if (!is_null($form) && !is_null($form->form_fields))
                    <form action="{{ route('dynamic-forms.update', $form->id) }}" method="POST">
                        @csrf
                        @method('PUT')

@foreach (json_decode($form->form_fields, true) as $key => $field)
    <div class="form-group">
        <label for="field_{{ $key }}">Label: {{ $field['label'] }}</label>
        <select id="html_field_{{ $key }}" name="fields[{{ $key }}][html_field]" class="form-control">
            <option value="text" @if ($field['html_field'] === 'text') selected @endif>Text</option>
            <option value="number" @if ($field['html_field'] === 'number') selected @endif>Number</option>
            <option value="select" @if ($field['html_field'] === 'select') selected @endif>Select</option>
        </select>
        <input type="text" id="helper_text_{{ $key }}" name="fields[{{ $key }}][helper_text]" class="form-control" value="{{ old('fields.' . $key . '.helper_text', $field['helper_text'] ?? '') }}" placeholder="Helper Text">

        <!-- Add Edit and Delete buttons -->
        <a href="{{ route('dynamic-forms.edit-field', [$form->id, $key]) }}" class="btn btn-sm btn-warning">Edit</a>
        <a href="{{ route('dynamic-forms.delete-field', [$form->id, $key]) }}" class="btn btn-sm btn-danger">Delete</a>
    </div>
@endforeach


                        @can('edit_forms')
                            <button type="submit" class="btn btn-primary">Update Form</button>
                        @endcan
                    </form>
                @else
                    <p>No form or form fields found.</p>
                @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
