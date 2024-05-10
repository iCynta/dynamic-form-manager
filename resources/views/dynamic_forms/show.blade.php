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
                    <div class="card-header">{{$form->form_name}}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('submit-form') }}">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="form_id" value="{{ $form->id }}">
                            <input type="hidden" name="form_name" value="{{ $form->form_name }}">

                            <div id="form_fields">
                                <!-- Dynamic fields will be added here -->
                                @foreach (json_decode($form->form_fields, true) as $key => $field)
                                    <div class="form-group">
                                        <label for="field_{{ $key }}" class="form-label">{{ $field['label'] }}</label>
                                        @if ($field['html_field'] === 'text')
                                            <input type="text" id="field_{{ $key }}" name="fields[{{ $key }}][{{$field['label']}}]" class="form-control" value="{{ old('fields.' . $key . '.value', $field['value'] ?? '') }}">
                                        @elseif ($field['html_field'] === 'number')
                                            <input type="number" id="field_{{ $key }}" name="fields[{{ $key }}][{{$field['label']}}]" class="form-control" value="{{ old('fields.' . $key . '.value', $field['value'] ?? '') }}">
                                        @elseif ($field['html_field'] === 'select')
                                            <select id="field_{{ $key }}" name="fields[{{ $key }}][{{$field['label']}}]" class="form-control">
                                                @foreach ($field['options'] as $option)
                                                    <option value="{{ $option }}" @if (old('fields.' . $key . '.value', $field['value'] ?? '') === $option) selected @endif>{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <small class="form-text text-muted">{{ $field['helper_text'] }}</small>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Submit button with margin -->
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                        <a href="{{route('dashboard')}}" class="btn btn-sm btn-dark">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
