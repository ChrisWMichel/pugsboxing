@extends('layouts.admin_layout')


@section('content')
    @include('includes.tinyeditor')
    <h2 class="page-header">About Page</h2>

    {!! Form::model($about, ['method'=>'Patch', 'action'=> ['admin\AboutController@update',  $about->id]]) !!}
    {{csrf_field()}}

    <div class="form-group">
    {!! Form::textarea('body', $about->body, ['class' => 'form-control', 'rows' => 18]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary pull-right']) !!}
    </div>

    {!! Form::close() !!}

    <div class="alert">
        @include('flash::message')
    </div>

@endsection