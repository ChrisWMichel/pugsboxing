@extends('layouts.admin_layout')

@section('css')

@endsection

@section('content')

    <h2 class="page-header">Create New Administrator</h2>
<div class="row">
<div class="col-lg-6">
    {!! Form::open(['method'=>'POST', 'action'=>'admin\MainAdminController@storeAdmin']) !!}

    <div class="form-group">

        {!! Form::label('firstname', 'First Name:') !!}
        {!! Form::text('firstname', null, ['class'=>'form-control', 'required' => 'required']) !!}

    </div>
    <div class="form-group">

        {!! Form::label('lastname', 'Last Name:') !!}
        {!! Form::text('lastname', null, ['class'=>'form-control', 'required' => 'required']) !!}

    </div>
    <div class="form-group">

        {!! Form::label('email', 'Email:') !!}<br>
        {!! Form::text('email', NULL, ['class'=>'form-control', 'required' => 'required']) !!}

    </div>
    <div class="form-group">
        {!! Form::submit('Add Admin', ['class' => 'btn btn-primary', 'id' => 'newAdmin']) !!}
    </div>


    {!! Form::close() !!}

    @if(count($errors))
        <div class="form-group">
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="alert">
        @include('flash::message')
    </div>

</div>
    <div class="col-lg-6  pull-right">
        @if(!empty($admins))
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Admins</th>
                    <th>Delete</th>

                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{$admin->firstname}} {{$admin->lastname}}</td>
                        {!! Form::open(['method'=>'DELETE', 'action'=>['admin\MainAdminController@destroy', $admin->id]]) !!}

                        <td>{!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}</td>

                        {!! Form::close() !!}
                    </tr>
               @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

@section('scripts')

   {{-- <script>
        $("#newAdmin").submit(function (e) {
            $('#dialog').dialog();
            e.preventDefault();
        });
    </script>--}}

@endsection