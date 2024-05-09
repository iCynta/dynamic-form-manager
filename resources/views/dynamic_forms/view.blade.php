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
                                <label for="field_{{ $key }}">{{ $field['label'] }}</label>
                                @if ($field['html_field'] === 'text')
                                    <input type="text" id="field_{{ $key }}" name="fields[{{ $key }}][value]" class="form-control" value="{{ old('fields.' . $key . '.value', $field['value'] ?? '') }}">
                                @elseif ($field['html_field'] === 'number')
                                    <input type="number" id="field_{{ $key }}" name="fields[{{ $key }}][value]" class="form-control" value="{{ old('fields.' . $key . '.value', $field['value'] ?? '') }}">
                                @elseif ($field['html_field'] === 'select')
                                    <select id="field_{{ $key }}" name="fields[{{ $key }}][value]" class="form-control">
                                        @foreach ($field['options'] as $option)
                                            <option value="{{ $option }}" @if (old('fields.' . $key . '.value', $field['value'] ?? '') === $option) selected @endif>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <small class="form-text text-muted">{{ $field['helper_text'] }}</small>

                                @can('edit_fields')
                                    <a href="{{ route('edit_field', [$form->id, $key]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ route('delete_field', [$form->id, $key]) }}" class="btn btn-sm btn-danger">Delete</a>
                                @endcan
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
