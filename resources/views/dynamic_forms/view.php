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
        
    </script>
@endsection
