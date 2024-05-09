    @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dynamic Forms') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan='3'>
                                        <a href={{route('create-new-form')}} class="btn btn-md btn-success float-end">NEW</a>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Si:no</th>
                                    <th> Form</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($forms as $form)
                                <tr>
                                    <td class="col-1">{{ $form->id }}</td>
                                    <td class="col-8">{{ $form->form_name }}</td>
                                    <td class="col-3"> 
                                        <button class="btn btn-sm btn-primary">VIEW</button>
                                        <button class="btn btn-sm btn-warning">EDIT</button>
                                        <button class="btn btn-sm btn-danger">DELETE</button>
                                    </td>                                    
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
