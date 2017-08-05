@extends('layouts.admin_layout')


@section('content')
    <div class="col-lg-7 bottom-buffer">
        <h2 class="page-header">Add Packages for {{$member->firstname}} {{$member->lastname}}</h2>
        <h3 class="package-msg blue-title"></h3>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#personals" aria-controls="personals" role="tab" data-toggle="tab">Personals</a></li>
            <li role="presentation"><a href="#boxing" aria-controls="boxing" role="tab" data-toggle="tab">Boxing Club</a></li>
            <li role="presentation"><a href="#sparring" aria-controls="sparring" role="tab" data-toggle="tab">Sparring</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="personals">
                <h3 class="page-header">Personals</h3>
                <form method="post" action="#">
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                    @foreach($packages as $package)
                        {{csrf_field()}}
                        @if($package->category->name == 'Personal')
                            <input type="radio" class="package-choice" name="package" value="{{$package->id}}">{{$package->package}}<br>
                        @endif
                    @endforeach
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="boxing">
                <h3 class="page-header">Boxing Club</h3>
                <form action="#" id="boxing-club-form">
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                        {{csrf_field()}}
                    <div class="form-group">
                        {!! Form::label('start_date', 'Start Date:') !!}
                        {!! Form::text('start_date', \Carbon\Carbon::today()->format('m/d/Y'), ['id' => 'start_date']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('months', 'Number of months:') !!}
                        {!! Form::text('months', 3, ['id' => 'boxing-months', 'maxlength' => 2, 'class'=> 'state-member']) !!}
                    </div>
                    <div class="form-group">
                        <input type="button" value="Add Boxing Club" class="btn btn-primary btn-sm">
                    </div>

                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="sparring">
                <h3 class="page-header">Sparring</h3>

                <form action="#">
                    {{csrf_field()}}
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                    <div class="form-group">
                    <select id="sparring-choice">
                        <option class="sparring-choice" value="null">Select Rounds</option>
                        @foreach($sparring as $list)
                            <option class="sparring-choice" value="{{$list->id}}">{{$list->package}}</option>
                        @endforeach
                    </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="button" value="Add Rounds" class="btn btn-primary btn-sm sparring">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $('.package-choice').click(function(){
            const membership_id = $(this).val();
            const mem_id = $('#mem_id').val();

            const data = {
                'membership_id' : membership_id,
                'mem_id' : mem_id
            };
            const url = '/add_new_mem_pack';
            $.ajax({
                url    : url,
                type   : 'get',
                data   : data,
                success: function (data) {
                    if(data.update === true){
                        $('.package-msg').html('The ' + data.package + ' package has been updated for ' + data.firstname + '.' );
                    }else{
                        $('.package-msg').html('The ' + data.package + ' package has been added for ' + data.firstname + '.' );
                    }
                },
                error  : function (data) {
                    console.log('Something went wrong.');
                    console.log(data);
                }
            })
        });

        /* Boxing Club tab */
        $("#start_date").datepicker();

        $('#boxing-club-form').on('click', function(){
           // $(this).parents('.nav').find('.active').removeClass('active').end().end().addClass('active');
            const mem_id = $('#mem_id').val();
            const start_date = $('#start_date').val();
            const boxing_months = $('#boxing-months').val();

            const data = {
                'mem_id' : mem_id,
                'start_date' : start_date,
                'boxing_months' : boxing_months
            };
            console.log(data);

            const url = '/add_boxing_pack';
            $.ajax({
                url    : url,
                type   : 'get',
                data   : data,
                success: function (data) {
                    console.log(data);
                    //$(this).parents('.nav').find('a[href$="#boxing"]').addClass('.active');
                    if(data.update === true){
                        $('.package-msg').html(' Boxing Club status has been updated for ' + data.firstname ); // data.firstname +
                    }else{
                        $('.package-msg').html( data.firstname + ' has been added to the Boxing Club.' );
                    }

                },
                error  : function (data) {
                    //console.log('Something went wrong.');
                    //console.log(data);
                }
            })
        });

        /* Sparring Partner */

        $('.sparring').on('click', function(){
            const membership_id = $('#sparring-choice option:selected').val();
            const mem_id = $('#mem_id').val();

            const data = {
                'membership_id' : membership_id,
                'mem_id' : mem_id
            };

            const url = '/add_sparring_pack';
            $.ajax({
                url    : url,
                type   : 'get',
                data   : data,
                success: function (data) {
                    if(data.update === true){
                        $('.package-msg').html('The ' + data.package + ' package has been updated for ' + data.firstname + '.' );
                    }else{
                        $('.package-msg').html('The ' + data.package + ' package has been added for ' + data.firstname + '.' );
                    }
                },
                error  : function (data) {
                    console.log('Something went wrong.');
                    console.log(data);
                }
            })
        });
    </script>

@endsection