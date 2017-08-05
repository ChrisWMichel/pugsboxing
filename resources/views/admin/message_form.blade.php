

@extends('layouts.admin_layout')


@section('content')
    @include('includes.tinyeditor')
    <h2 class="page-header">Send a message to your members</h2>

    {!! Form::open(['method'=>'post', 'action'=> ['admin\MainAdminController@sendMessage']]) !!}
    {{csrf_field()}}

    <div class="form-group">
        {!! Form::radio('groups', 'members', TRUE) !!}
        {!! Form::label('groups', 'All members ') !!}&nbsp;&nbsp;
        {!! Form::radio('groups', 'boxing') !!}
        {!! Form::label('groups', 'Boxing Club only ') !!}
    </div>


    <div class="form-group">
        {!! Form::text('subject',null, ['class' => 'form-control', 'placeholder' => 'Subject']) !!}
    </div>

    <div class="form-group">
        {!! Form::textarea('message',null, ['class' => 'form-control', 'rows' => 18]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Send Message', ['class' => 'btn btn-primary pull-right']) !!}
    </div>

    {!! Form::close() !!}

    <div class="alert">
        @include('flash::message')
    </div>

@endsection