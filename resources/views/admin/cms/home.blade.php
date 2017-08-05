@extends('layouts.admin_layout')

@section('css')
    <style>

    </style>

@endsection

@section('content')
    @include('includes.tinyeditor')

    <h2 class="page-header">Home page</h2>
@if(!empty($home))
    <div class="col-lg-12 left-list">
        <h3>Left list</h3>
        {!! Form::open(['method'=>'Patch', 'action'=> ['admin\HomeController@update', $home->id]]) !!}
        {{--<input name="invisible" type="hidden" value="secret">--}}
        {!! Form::hidden('data', 'left-list') !!}
        {{csrf_field()}}


        <div class="form-group">

            {!! Form::label('left_list', 'Remember to add a comma before adding another statment.') !!}<br>
            {!! Form::text('left_list', $home->left_list, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}


        <h3>Home Title</h3>
        {!! Form::open(['method'=>'Patch', 'action'=> ['admin\HomeController@update', $home->id]]) !!}

        {!! Form::hidden('data', 'home_title') !!}
        {{csrf_field()}}


        <div class="form-group">

            {!! Form::label('home_title', 'Change Title.') !!}<br>
            {!! Form::text('home_title', $home->home_title, ['class' => 'form-control']) !!}

        </div>
        <div class="form-group">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
        {!! Form::close() !!}

        <h3>Main Content</h3>
        <div class="col-lg-11 bottom-buffer textarea-width">
            {!! Form::open(['method'=>'Patch', 'action'=> ['admin\HomeController@update', $home->id], 'files'=>true]) !!}
            {{--<input name="invisible" type="hidden" value="secret">--}}
            {!! Form::hidden('data', 'right_content') !!}
            {{csrf_field()}}


            <div class="form-group">

                {!! Form::label('right_content', 'Change Content:') !!}<br>
                {!! Form::textarea('right_content', $home->right_content, ['class' => 'form-control', 'rows' => 20]) !!}

            </div>
            <div class="form-group">
                {!! Form::submit('Save Changes', ['class' => 'btn btn-primary pull-right']) !!}
            </div>

            {!! Form::close() !!}
        </div>

@else
    <h2>No Content</h2>
@endif

@endsection