@extends('layouts.admin_layout')


@section('content')
<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered schedule-tble">

        {!! Form::open(['method'=>'POST', 'action'=>'admin\AppointmentsController@store']) !!}
            {{csrf_field()}}
            <thead>
            <tr>
                <th>{!! Form::label('member', 'Member:') !!}</th>
                <th>{!! Form::label('title', 'Title:') !!}</th>
                <th>{!! Form::label('color', 'Color:') !!}</th>
                <th>Date</th>
                <th>Time</th>
                <th>{!! Form::label('notes', 'Notes:') !!}</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {!! Form::text('member', null, array('placeholder' => 'Search member','class' => 'form-control','id'=>'autocomplete')) !!}
                        {!! Form::hidden('member_id', null, array('class' => 'form-control','id'=>'member_id')) !!}
                    </td>

                    <td>{!! Form::select('title', ['Personal Training'=> 'Personal Training', 'Sparring'=> 'Sparring', 'Other' => 'Other'], null, []) !!}</td>

                    <td>{!! Form::select('color', ['#65ab21'=> 'Green', '#aa7c21'=> 'Copper', '#d13429' => 'Red', '#297dd1' => 'Blue', '#d12971' => 'Pink'], null, []) !!}</td>

                    <td>{!! Form::text('dateSchedule', NULL, ['id' => 'date-schedule','class' => "short-length", 'required' => 'required']) !!}</td>

                    <td>{!! Form::text('timepicker1', NULL, ['id' => 'timepicker1', 'class' => "short-length", 'required' => 'required']) !!}</td>

                    <td>{!! Form::text('notes', NULL, []) !!}</td>

                    <td>{!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}</td>
                </tr>

        {!! Form::close() !!}
            </tbody>
        </table>
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
    </div>

</div>

    @include('flash::message')

<hr>
<div class="container">
    <div class="col-lg-10 col-lg-offset-1">
        <div id='calendar'></div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#date-schedule').datepicker();
            $('#timepicker1').timepicker();
        });
    </script>

    <script src= "{{asset('vendor/fullcalendar/lib/moment.min.js')}}"></script>
    <script src= "{{asset('vendor/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src= "{{asset('vendor/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
    {{--<script src= "{{asset('js/jquery.hideseek.js')}}"></script>--}}
   <script src="{{asset('js/scripts.js')}}"></script>
    <script>


        $(document).ready(function() {

            let now = new Date();
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                businessHours:{
                    start: '14:00:00',
                    end: '21:00:00',
                },

                //Duration: '21:00:00',
                defaultDate: now.setDate(now.getDate()),
                selectable: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                displayEventTime: true,
                events:[
                        @foreach($tasks as $task)
                    {
                        "title" : "{{$task->member->firstname}} {{$task->member->lastname}}",
                        "start": "{{$task->start}}",
                        "color": "{{$task->color}}",

                    },

                    @endforeach
                ]
            });


        /* Autocomplete code*/
            const src = '{{route("autocomplete")}}';
            $('#autocomplete').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: src,
                        dataType: 'json',
                        data: {
                            term : request.term
                        },
                        success: function (data) {

                            response(data);
                        }
                    });
                },
                minLength:2,
                select: function (event, ui) {
                    $('#member_id').val(ui.item.id);
                }

            });

        });

    </script>

@endsection