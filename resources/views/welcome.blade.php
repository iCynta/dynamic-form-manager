<!-- resources/views/forms/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1>List Of Available Forms</h1>
            <div class='table-responsive'>
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
                <table class="table table-bordered table-striped">
                            <thead class="background-dark bg-dark">
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
                                            <a href='{{ route('show-form', $form->id) }}' class="btn btn-sm btn-primary">VIEW</a>
                                            
                                        </td>                                    
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"><p class="text-alert text-warning text-center">No forms found at the moment</p></td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
            </div>
        </div>
    </div>

   @endsection
