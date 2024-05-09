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
                                @forelse ($forms as  $form)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $form->form_name }}</td>
                                        <td> 
                                            <a href='{{ route('dynamic-forms.view', $form->id) }}' class="btn btn-sm btn-primary">VIEW</a>
                                            <a href='{{ route('dynamic-forms.edit', $form->id) }}' class="btn btn-sm btn-warning">EDIT</a>
                                            <a href='{{ route('dynamic-forms.delete', $form->id) }}' class="btn btn-sm btn-danger">DELETE</a>
                                        </td>                                    
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No forms found</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
