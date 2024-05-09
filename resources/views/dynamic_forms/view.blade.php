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
                <form method="POST" action="{{ route('submit-form') }}">
                    @csrf
                    <input type="hidden" name="form_id" value="{{ $form->id }}">
                    <input type="hidden" name="form_name" value="{{ $form->form_name }}">

                    @foreach (json_decode($form->form_fields, true) as $key => $field)
                        <div class="form-group">
                            <label for="field_{{ $key }}">{{ $field['label'] }}</label>
                            @if ($field['html_field'] === 'text')
                                <input type="text" id="field_{{ $key }}" name="form_data[{{ $field['label'] }}]" class="form-control">
                            @elseif ($field['html_field'] === 'number')
                                <input type="number" id="field_{{ $key }}" name="form_data[{{ $field['label'] }}]" class="form-control">
                            @elseif ($field['html_field'] === 'select')
                                <select id="field_{{ $key }}" name="form_data[{{ $field['label'] }}]" class="form-control">
                                    @foreach ($field['options'] as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div><br/>
                    @endforeach
                    <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Submit Form</button>
                    </div>
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
