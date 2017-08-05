@extends('layouts.admin_layout')


@section('content')
    @include('includes.tinyeditor')
    <h2 class="page-header">Description for packages</h2>

    @foreach($descriptions as $description)
    {!! Form::model($description, ['method'=>'Patch', 'action'=> ['admin\MembershipController@update',  $description->id]]) !!}
    {{csrf_field()}}

    <div class="form-group">
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', $description->title, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
    {!! Form::textarea('body', $description->body, ['class' => 'form-control', 'rows' => 10]) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary pull-right descSaveBtn']) !!}
    </div><br>

    {!! Form::close() !!}
    @endforeach
@endsection

@section('scripts')

@endsection