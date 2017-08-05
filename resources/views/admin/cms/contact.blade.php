@extends('layouts.admin_layout')

@section('css')
    <style>

    </style>

@endsection

@section('content')

    <h2 class="page-header">Contact Information</h2>

    <div class="col-lg-8 bottom-buffer">
        {!! Form::open(['method'=>'Patch', 'action'=> ['admin\ContactController@update', $info->id]]) !!}
        {{csrf_field()}}


        <div class="form-group">
            {!! Form::label('title', 'Name of Gym:') !!}<br>
            {!! Form::text('title', $info->title, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('phone', 'Phone number:') !!}<br>
            {!! Form::text('phone', $info->phone, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('street', 'Address:') !!}<br>
            {!! Form::text('street', $info->street, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('city', 'City') !!}<br>
            {!! Form::text('city', $info->city, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('state', 'State') !!}<br>
            {!! Form::text('state', $info->state, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('zipcode', 'Zipcode:') !!}<br>
            {!! Form::text('zipcode', $info->zipcode, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::submit('Update Changes', ['class' => 'btn btn-primary pull-right']) !!}
        </div>

        {!! Form::close() !!}
    </div>

    <div class="col-lg-4 bottom-buffer">
        <div class="alert">
            @include('flash::message')
        </div>
    </div>
@endsection