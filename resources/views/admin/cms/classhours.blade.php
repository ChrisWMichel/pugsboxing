@extends('layouts.admin_layout')

@section('css')
    <style>
        table tr td{
            text-align:center;
            vertical-align:middle !important;
        }
    </style>

@endsection

@section('content')
<div class="col-md-8">
    <table class="table table-striped table-bordered table-hover toppad">
        <thead>
        <tr>
            <th>Labels for hours of business</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
        <tr>
            <form method="post" action="#" id="{{$group->id}}" class="group-form">
                {{csrf_field()}}

            <td><input type="text" name="group_name" value="{{$group->name}}" class="form-control"> </td>
            <td><input type="submit"  value="Save Changes" class="btn btn-sm btn-primary"> </td>
            </form>
            <td><a href="#" id="{{$group->id}}" class="group-delete btn btn-sm btn-danger">X</a> </td>
        </tr>
        @endforeach
        <tr>
            <form method="post" action="#">
                <td><input type="text" name="group_create" id="group_create" class="form-control" required> </td>
                <td class="center"><input type="button"  value="New Group" class="btn btn-sm btn-success create_group"> </td>
            </form>
        </tr>
        </tbody>
    </table>
</div>
<div class="col-md-4">
    <div class="alert">
        @include('flash::message')
    </div>
</div>
<hr>
<?php $oldID = null ?>
@foreach($hours as $hour)
    <?php $newID = $hour->groupHour->id ?>
    @if($oldID != $newID)
    <table class="table table-striped table-bordered table-hover">
        <caption><h3>{{$hour->groupHour->name}}</h3></caption>
        <thead>
        <tr>
            <th>Description</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($hours as $time)
            @if($time->groupHour->id === $hour->groupHour->id)
                <tr>
                {!! Form::model($time, ['method'=>'Patch', 'action'=> ['admin\ScheduleController@update',  $time->id]]) !!}
                {{csrf_field()}}

                    <td> {!! Form::text('description', $time->description, ['class' => 'form-control', 'required' => 'required']) !!}</td>
                    <td> {!! Form::text('time', $time->time, ['class' => 'form-control', 'required' => 'required']) !!}</td>
                    <td> {!! Form::submit('Save Changes', ['class' => 'btn btn-sm btn-primary']) !!}</td>
                    {{--<td><a href="{{route('schedule.destroy', $time->id)}}" class="btn btn-sm btn-danger">X</a></td>--}}

                {!! Form::close() !!}
                    {!! Form::model($time, ['method'=>'Delete', 'action'=> ['admin\ScheduleController@destroy',  $time->id]]) !!}
                    {{csrf_field()}}
                        <td> {!! Form::submit('X', ['class' => 'btn btn-sm btn-danger']) !!}</td>
                    {!! Form::close() !!}
                </tr>
            @endif
        @endforeach
        <tr>
            {!! Form::open(['method'=>'Post', 'action'=> ['admin\ScheduleController@store']]) !!}
            {{csrf_field()}}
                  {!! Form::hidden('group_hour_id', $hour->groupHour->id) !!}
            <td> {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}</td>
            <td> {!! Form::text('time', null, ['class' => 'form-control', 'required' => 'required']) !!}</td>
            <td> {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}</td>

            {!! Form::close() !!}
        </tr>
        </tbody>
    </table>
    @endif
    <?php $oldID = $hour->groupHour->id ?>
@endforeach
@if(!empty($group_name))
    <table class="table table-striped table-bordered table-hover">
        <caption><h3>{{$group_name->name}}</h3></caption>
        <thead>
        <tr>
            <th>Description</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            {!! Form::open(['method'=>'Post', 'action'=> ['admin\ScheduleController@store']]) !!}
            {{csrf_field()}}
            {!! Form::hidden('group_hour_id', $group_name->id) !!}
            <td> {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}</td>
            <td> {!! Form::text('time', null, ['class' => 'form-control', 'required' => 'required']) !!}</td>
            <td> {!! Form::submit('Add', ['class' => 'btn btn-success']) !!}</td>

            {!! Form::close() !!}
        </tr>

        </tbody>
    </table>
@endif

@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('.group-form').on('submit', function (e) {
                e.preventDefault();
                const id = this.id;
                let group_name = $(this.group_name).val();

                data = {
                    'id': id,
                    'group_name' : group_name
                };
                const url = '/group_name';

                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        //console.log(data);
                       location.reload();
                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                        console.log(data);
                    }
                })
            });

            $('.group-delete').click(function(){

                const id = $(this).attr('id');
                const url = '/group_delete';

                $.ajax({
                    url    : url,
                    type   : 'get',
                    data   : {'id':id},
                    success: function (data) {
                        //console.log(data);
                        location.reload();
                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                        console.log('failed: ' + data);
                    }
                })
            });

            $('.create_group').on('click', function(){
                let name = $('#group_create').val();


                let data = {
                    'name' : name
                };


                const url = "/group_create";

                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        location.reload();
                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                    }
                })

            });


        });
    </script>

@endsection