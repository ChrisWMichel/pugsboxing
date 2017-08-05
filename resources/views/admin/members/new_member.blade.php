@extends('layouts.admin_layout')


@section('content')

    <h2 class="page-header">New Member</h2>
<div id="new-member-packages">
    <div class="col-lg-7 bottom-buffer member-form">
        {!! Form::open(['method'=>'Post', 'action'=> ['admin\MembersController@store']]) !!}
        {{csrf_field()}}

        <div class="form-group">
            {!! Form::label('firstname', 'First Name:') !!}
            {!! Form::text('firstname', null, []) !!}
            &nbsp;

            {!! Form::label('lastname', 'Last Name:') !!}
            {!! Form::text('lastname', null, []) !!}

        </div>
        <div class="form-group">
            {!! Form::label('phone', 'Phone Number:') !!}
            {!! Form::text('phone', null, ['class' => 'short-length', 'maxlength' => 12]) !!}
            &nbsp;

            {!! Form::label('emergency_phone', 'Emergency Phone:') !!}
            {!! Form::text('emergency_phone', null, ['class' => 'short-length', 'maxlength' => 12]) !!}

        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}<br>
            {!! Form::text('email', null, ['class' => 'input-length']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('street', 'Address:') !!}<br>
            {!! Form::text('street', null, ['class' => 'input-length']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('city', 'City:') !!}
            {!! Form::text('city', null, []) !!}
            &nbsp;

            {!! Form::label('state', 'State:') !!}
            {!! Form::text('state', null, ['class'=> 'state-member', 'maxlength' => 2]) !!}
            &nbsp;

            {!! Form::label('zipcode', 'Zipcode:') !!}
            {!! Form::text('zipcode', null, ['class' => 'short-length']) !!}

        </div>
        <div class="form-group">
            {!! Form::label('DOB', 'DOB:') !!}
            {!! Form::text('DOB', null, ['id' => 'dob' ]) !!}

        </div>

        <div class="form-group">
            {!! Form::label('startMember', 'Membership Start:') !!}
            {!! Form::text('startMember', null, ['id' => 'startDate']) !!}
            &nbsp;

            {!! Form::label('endMember', 'End:') !!}
            {!! Form::text('endMember', null, ['id' => 'endDate']) !!}

        </div>
        <div class="form-group">
            {!! Form::submit('Add New Member', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>
    <div class="col-lg-5 bottom-buffer">
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
@endsection

@section('scripts')

    <script>
        $( function() {
            //$( "#startDate" ).datepicker();

            $("#startDate").datepicker({
                onSelect: function() {
                    let startDate = $(this).datepicker('getDate');

                    let year = startDate.getFullYear() + 1;
                    let month = startDate.getMonth() + 1;
                    let day = startDate.getDate();
                    let endDate = new Date(year + 1, month, day);

                    $('#endDate').val(month + '/' + day + '/' + year);

                }
            });

            $("#endDate").datepicker();

            $( "#dob" ).datepicker({
                yearRange: '-75:+0',
                changeMonth: true,
                changeYear: true
            });

        } );

        /*$('#myTabs').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })*/

        /* maybe use this for DOB

          $(function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
        * */
    </script>

@endsection