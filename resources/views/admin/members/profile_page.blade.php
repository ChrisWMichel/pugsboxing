


<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#packages" aria-controls="packages" role="tab" data-toggle="tab">Packages</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="profile">
        <div class="top-buffer"></div>

                <div class="form-group">
                    <label>First Name:</label> <input type="text" id="firstname" value="{{$member->firstname}}" class="noStyleText increaseFont shorten-firstname " disabled>
                    &nbsp;
                    <label>Last Name:</label> <input type="text" id="lastname" value="{{$member->lastname}}" class="noStyleText increaseFont" disabled>
                </div>
                <div class="form-group">
                    <label>Phone Number:</label> <input type="text" id="phone" value="{{$member->phone}}" class="noStyleText short-length" disabled>
                    &nbsp;
                    <label>Emergency Number:</label> <input type="text" id="emergency_phone" value="{{$member->emergency_phone}}" class="noStyleText" disabled>

                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <a href="#emailMember" data-toggle="modal" data-target="#emailMember">
                    <input type="text" id="email" value="{{$member->email}}" class="noStyleText" disabled>
                   </a>
                    <h3 id="messageSent" class="orange-title"></h3>
                </div>
                <div class="form-group">
                    <label>Address:</label><br>
                    <input type="text" id="street" value="{{$member->street}}" class="noStyleText" disabled><br>
                    <input type="text" id="city" value="{{$member->city}}" class="noStyleText short-length" disabled>,
                    <input type="text" id="state" value="{{$member->state}}" class="noStyleText" disabled><br>
                    <input type="text" id="zipcode" value="{{$member->zipcode}}" class="noStyleText " disabled>
                </div>

                <div class="form-group">
                    <label>DOB:</label> <input type="text" id="DOB" value="{{$member->DOB}}" class="noStyleText" disabled>

                </div>

                <div class="form-group">
                    <label>Membership:</label><br>
                    <?php
                    $now = \Carbon\Carbon::now();
                    $start =  \Carbon\Carbon::parse($member->startMember);
                    $end = \Carbon\Carbon::parse($member->endMember);
                    $monthDiff = $start->diffInMonths($end);
                    ?>
                    @if($now > $end )
                        <label>Start:</label> <input type="text" id="startDate" value="{{$member->startMember}}" class="noStyleText increaseFont short-length mem-expired" disabled>
                        <label>End:</label>  <input type="text" id="endDate" value="{{$member->endMember}}" class="noStyleText increaseFont mem-expired" disabled><br>
                        <button class="btn btn-danger archive-member" id="{{$member->id}}">Archive</button>
                        <h4 class="archive-msg blue-title"></h4>
                    @else
                        <label>Start:</label> <input type="text" id="startDate" value="{{$member->startMember}}" class="noStyleText increaseFont short-length" disabled>
                        <label>End:</label>  <input type="text" id="endDate" value="{{$member->endMember}}" class="noStyleText increaseFont" disabled>
                        @if($monthDiff >= 1 && $now < $end)
                            <h4>Membership ends in {{$monthDiff}} months</h4>
                        @endif
                    @endif

                </div>

            <button type="button" class="btn btn-primary edit-btn" id="{{$member->id}}" data-toggle="modal" data-target="#editProfile">
                Edit Profile
            </button>

    </div>
    <div role="tabpanel" class="tab-pane" id="packages">
        @if(!empty($appointments))
        <div class="well well-sm">
            <a href="#secheduleLog" data-toggle="modal" id="{{$member->id}}" data-target="#secheduleLog">Appointment Log</a>
        </div>
        @endif
        <div class="well well-lg">
            <h3>Personals:</h3>
            @if(empty($personals))
                <h4>Setup personal package</h4>
                <form method="post" action="#">
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                    @foreach($packages as $package)
                        {{csrf_field()}}
                        @if($package->category->name == 'Personal')
                            <input type="radio" class="package-choice" name="package" value="{{$package->id}}">{{$package->package}}<br>
                        @endif
                    @endforeach
                </form>
                <h3 class="package-msg blue-title"></h3>
            @else
                <div class="form-group">
                    <label>Total Lessons: </label> <input type="text" id="totalLessons" value="{{$personals->total_lessons}}" class="increaseFont noStyleText" disabled><br>
                    <label>Lessons Not Taken:</label> <input type="text" id="lessonsLeft" value="{{$personals->lessons_left}}" class="increaseFont noStyleText" disabled>

                </div>
            <div class="row hideLessons">
                <div class="col-sm-4">
                    <h4>Add Lessons</h4>
                    <input type="text" class="add-lessons shorter-length" maxlength="2">
                    <input type="button" id="{{$personals->id}}" value="Add" class="btn btn-sm addLessons">
                </div>
                <div class="col-sm-4">
                    <h4>Subtract Lessons</h4>
                    <input type="text" class="subtract-lessons shorter-length" value="1" maxlength="2">
                    <input type="button" id="{{$personals->id}}" value="Subtract" class="btn btn-sm subtractLessons">
                </div>
            </div>
                <h3 class="packageComplete-msg blue-title"></h3>
            @endif
        </div>
        <div class="well well-lg">
            @if(empty($boxing_club))
                <h3>Boxing Club</h3>
                <h4>Add Package</h4>
                <form action="#">
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Start Date:</label>
                        <input type="text", value="{{\Carbon\Carbon::today()->format('m/d/Y')}}" id="boxingClubDate">
                    </div>
                    <div class="form-group">
                        <label>Number of months:</label>
                        <input type="text" id="boxing-months" maxlength="2" class="shorter-length" value="3">
                    </div>
                    <div class="form-group">
                        <input type="button" value="Add Boxing Club" class="btn btn-primary btn-sm boxing-club-form" id="{{$member->id}}">
                    </div>
                </form>
                <h3 class="boxingClub-msg"></h3>
            @else
                <h3>Boxing Club</h3>
                <form action="#" class="hideBoxingFrm">
                    <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                    {{csrf_field()}}

                        <label>Start Date:</label>
                        <input type="text" value="{{$boxing_club->start_date}}" id="boxingClubDate">


                        <label>For</label>
                        <input type="text" id="boxing-months" maxlength="2" class="shorter-length" value="{{$boxing_club->months}}"> months

                        <input type="button" value="Update" class="btn btn-primary btn-sm update-boxing-club" id="{{$member->id}}">
                </form>
                <?php
                $start =  \Carbon\Carbon::parse($boxing_club->start_date);
                $end = \Carbon\Carbon::parse($boxing_club->end_date);
                $weekDiff = $start->diffInWeeks($end);
                ?>
                @if($weekDiff == 1)
                    <h4 class="red-title">Package ends in one week.</h4>
                @elseif($start > $end)
                    <h4 class="red-title hideBoxingFrm">Membership for boxing club ended {{$weekDiff}} weeks ago.</h4>
                    <h4 class="red-title hideBoxingFrm">Remove {{$member->firstname}} from the boxing club <a href="#" id="{{$member->id}}" class="btn btn-danger removeBoxingClub">Remove</a> </h4>
                @else
                    <h4>Package ends in <input type="text" id="weeksLeft" value="{{$weekDiff}}" class="noStyleText shorter-length">weeks.</h4>
                @endif

                <h4 class="boxingClub-msg blue-title"></h4>
            @endif

        </div>
        <div class="well well-lg">
            <h3>Sparring</h3>
            @if(empty($sparring))
            <form action="#">
                {{csrf_field()}}
                <input type="hidden" name="mem_id" id="mem_id" value="{{$member->id}}">
                <div class="form-group">
                    <select id="sparring-choice">
                        <option class="sparring-choice" value="null">Select Rounds</option>
                        @foreach($sparringPackage as $list)
                            <option class="sparring-choice" value="{{$list->id}}">{{$list->package}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <input type="button" value="Add Rounds" class="btn btn-primary btn-sm sparring">
                </div>
            </form>
                <h3 class="blue-title sparring-msg"></h3>
            @else
                <div class="form-group">
                    <label>Total Rounds: </label> <input type="text" id="totalRounds" value="{{$sparring->rounds}}" class="increaseFont noStyleText" disabled><br>
                    <label>Rounds Left:</label> <input type="text" id="RoundsLeft" value="{{$sparring->rounds_left}}" class="increaseFont noStyleText" disabled>
                    {{--@if(!empty($appointments))
                        <a href="#sparring_log" data-toggle="modal" id="{{$member->id}}"  data-target="#sparring_log">Sparring Log</a>
                    @endif--}}
                </div>
                <div class="row hideSparring">
                    <div class="col-sm-4">
                        <h4>Add rounds</h4>
                        <input type="text" class="add-rounds shorter-length" maxlength="2">
                        <input type="button" id="{{$sparring->id}}" value="Add" class="btn btn-sm addSparring">
                    </div>
                    <div class="col-sm-4">
                        <h4>Subtract rounds</h4>
                        <input type="text" class="subtract-rounds shorter-length" value="1" maxlength="2">
                        <input type="button" id="{{$sparring->id}}" value="Subtract" class="btn btn-sm subtractSparring">
                    </div>
                </div>
                <h3 class="blue-title sparringComplete-msg"></h3>
            @endif
        </div>
    </div>

</div>

@include('admin.members.modal_edit')
@include('admin.members.modal_emailMember')
@include('admin.members.modal_persoanl_appointments')
{{--@include('admin.members.modal_sparring_appointments')--}}  {{--Not working--}}


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#newStartDate").datepicker({
        onSelect: function() {
            let startDate = $(this).datepicker('getDate');

            let year = startDate.getFullYear() + 1;
            let month = startDate.getMonth() + 1;
            let day = startDate.getDate();
            let endDate = new Date(year + 1, month, day);

            $('#endDate2').val(month + '/' + day + '/' + year);

        }
    });

    $('#boxingClubDate').datepicker();

    $("#endDate2").datepicker();

    $( "#dob2" ).datepicker({
        yearRange: '-75:+0',
        changeMonth: true,
        changeYear: true
    });


/*  Load data into modal */
    $('.edit-btn').click(function(){
        const member_id = $(this).attr('id');

        const url = 'member_edit_profile';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : {'id' : member_id},
            success: function (response) {
                //console.log(response);
                $('#firstname2').val(response.firstname);
                $('#lastname2').val(response.lastname);
                $('#phone2').val(response.phone);
                $('#emergency_phone2').val(response.emergency_phone);
                $('#email2').val(response.email);
                $('#street2').val(response.street);
                $('#city2').val(response.city);
                $('#state2').val(response.state);
                $('#zipcode2').val(response.zipcode);
                $('#dob2').val(response.DOB);
                $('#newStartDate').val(response.startMember);
                $('#endDate2').val(response.endMember);
            },
            error  : function (data) {
                console.log('Something went wrong.');
                console.log(data);
            }
        })
    });

    /* Get all the data from the modal form - update it, and return the updated data back to the form */
    $('.updateBtn').click(function(e){
        e.preventDefault();
        let member_id = $(this).attr('id');

        data = {
            "firstname" : $('input[name=firstname2]').val(),
            "lastname" : $('input[name=lastname2]').val(),
            "phone" : $('input[name=phone2]').val(),
            "emergency_phone" : $('input[name=emergency_phone2]').val(),
            "email" : $('input[name=email2]').val(),
            "street" : $('input[name=street2]').val(),
            "city" : $('input[name=city2]').val(),
            "state" : $('input[name=state2]').val(),
            "zipcode" : $('input[name=zipcode2]').val(),
            "DOB" : $('#dob2').val(),
            "startMember" : $('#newStartDate').val(),
            "endMember" : $('#endDate2').val(),
        };

        const url = 'update_member/' + member_id;

        // Took out ajax.setup and put it on top
        $.ajax({
            url    : url,
            type   : 'post',
            data   : data,
            success: function (data) {
                //console.log(data);
                $('#editProfile').modal('toggle');

                $('#firstname').val(data.firstname);
                $('#lastname').val(data.lastname);
                $('#phone').val(data.phone);
                $('#emergency_phone').val(data.emergency_phone);
                $('#email').val(data.email);
                $('#street').val(data.street);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#zipcode').val(data.zipcode);
                $('#dob').val(data.DOB);
                $('#startDate').val(data.startMember);
                $('#endDate').val(data.endMember);
            },
            error  : function (xhr, ajaxOptions, thrownError) {
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        })
    });

    $('.addLessons').on('click', function(){
        const personal_id = $(this).attr('id');
        const addLessons = $('.add-lessons').val();

        const data = {
            'personal_id' : personal_id,
            'addLessons' : addLessons
        };

        const url = '/add_personals';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
               // console.log(data);
                $('#lessonsLeft').val(data.lessons_left);

            },
            error  : function (data) {
                console.log('Lesson was not added.');
                console.log(data);
            }
        })

    });

    $('.subtractLessons').on('click', function(){
        const personal_id = $(this).attr('id');
        const subtractLessons = $('.subtract-lessons').val();

        const data = {
            'personal_id' : personal_id,
            'subtractLessons' : subtractLessons
        };

        const url = '/subtract_personals';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
                //console.log(data);
                if(data.completed === true){
                    $('.hideLessons').css({'display' : 'none'});
                    $('.packageComplete-msg').html(data.firstname + ' has completed the package.');
                }else{
                    //console.log(data);
                    $('#lessonsLeft').val(data.lessons_left);
                }

            },
            error  : function (data) {
                console.log('Lesson was not subtracted.');
                console.log(data);
            }
        })

    });

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

    $('.boxing-club-form, .update-boxing-club').on('click', function(){
        // $(this).parents('.nav').find('.active').removeClass('active').end().end().addClass('active');
        const mem_id = $('#mem_id').val();
        const start_date = $('#boxingClubDate').val();
        const boxing_months = $('#boxing-months').val();

        const data = {
            'mem_id' : mem_id,
            'start_date' : start_date,
            'boxing_months' : boxing_months
        };
        //console.log(data);

        const url = '/add_boxing_pack';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
                //console.log(data);
                if(data.update === true){
                    $('#weeksLeft').val(data.weeksLeft);
                    $('.boxingClub-msg').html(' Boxing Club status has been updated.' ); // data.firstname +
                }else{
                    $('.boxingClub-msg').html(' Boxing Club has been added.' );
                }
            },
            error  : function (data) {
                //console.log('Something went wrong.');
                //console.log(data);
            }
        })
    });

    /* Add sparring package */
    $('.sparring').on('click', function(){
        const membership_id = $('#sparring-choice option:selected').val();
        const mem_id = $('#mem_id').val();

        const data = {
            'membership_id' : membership_id,
            'mem_id' : mem_id
        };

        //console.log(data);
        const url = '/add_sparring_pack';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
                if(data.update === true){
                    $('.sparring-msg').html('The ' + data.package + ' package has been updated for ' + data.firstname + '.' );
                }else{
                    $('.sparring-msg').html('The ' + data.package + ' package has been added for ' + data.firstname + '.' );
                }
            },
            error  : function (data) {
                console.log('Something went wrong.');
                console.log(data);
            }
        })
    });

    /* Add sparring rounds*/
    $('.addSparring').on('click', function(){
        const sparring_id = $(this).attr('id');
        const addRounds = $('.add-rounds').val();

        const data = {
            'sparring_id' : sparring_id,
            'addRounds' : addRounds
        };

        const url = '/add_sparring';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
                //console.log(data);
                $('#RoundsLeft').val(data.rounds_left);
            },
            error  : function (data) {
                console.log('Something went wrong.');
                console.log(data);
            }
        })
    });

    $('.subtractSparring').on('click', function(){
        const sparring_id = $(this).attr('id');
        const subtractRounds = $('.subtract-rounds').val();

        const data = {
            'sparring_id' : sparring_id,
            'subtractRounds' : subtractRounds
        };

        const url = '/subtract_sparring';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
                //console.log(data);
                if(data.completed === true){
                    $('.hideSparring').css({'display' : 'none'});
                    $('.sparringComplete-msg').html(data.firstname + ' has completed the sparring package.');
                }else{
                    //console.log(data);
                    $('#RoundsLeft').val(data.rounds_left);
                }

            },
            error  : function (data) {
                console.log('Something went wrong.');
                console.log(data);
            }
        })
    });

    $('.archive-member').on('click', function(){
        const mem_id = $(this).attr('id');

        const url = '/archive_member';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : {'id' : mem_id},
            success: function (data) {
                //console.log(data);
                $('.archive-member').css({"display" : "none"});
                $('.archive-msg').html('Member has been archived successfully.');
            },
            error  : function (data) {
                console.log('Member was not archived');
                console.log(data);
            }
        })
    });

    $('.removeBoxingClub').on('click', function(){
        const mem_id = $(this).attr('id');

        const url = '/remove_boxing_pack';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : {'id' : mem_id},
            success: function (data) {
                //console.log(data);
                $('.hideBoxingFrm').css({"display" : "none"});
                $('.boxingClub-msg').html(data.firstname + ' has been removed from the boxing club successfully.');
            },
            error  : function (data) {
                console.log('Member was not removed');
                console.log(data);
            }
        })
    });

    /* Validating the subject field in the modal email box*/
    $('#adminSubject').focus(function(){
        $('p.subjectEmpty').html('');
        $('#adminSubject').css({'border' : '1px black solid'});
    });

    $('.sendEmailMember').on('click', function(){

        data = {
            'mem_id' : $(this).attr('id'),
            'subject' : $('#adminSubject').val(),
            'message' : $('.admin_message').val()
        };

        if(data.subject === ""){
            $('p.subjectEmpty').html('You need to add a subject.');
            $('#adminSubject').css({'border' : '1px red solid'});
            return;
        }

        const url = '/email_member';
        $.ajax({
            url    : url,
            type   : 'post',
            data   : data,
            success: function (data) {
                //console.log(data);
                $('#emailMember').modal('toggle');
                $('#messageSent').html('Your message has been sent.');
            },
            error  : function (data) {
                console.log('Email was not sent.');
                console.log(data);
            }
        })
    });

    $('.updateAppoint').on('click', function(){

        let id = $(this).attr('id');
        let note = $('#note' + id).val();
       // console.log(note);
        data = {
            'appoint_id' : id,
            'note' : note,
        };

        if(data.note === ""){
            $('#row' + id).removeClass('hide-msg');
            $('#msg'+ id).html('You have to write something first before updating it.');
            return;
        }

        //console.log(data);
        const url = '/update_appointments';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : data,
            success: function (data) {
                $('#' + id).hide();
                $('#row' + id).removeClass('hide-msg');
                $('#msg'+ id).html('Notes were updated successfully.');
            },
            error  : function (data) {
                console.log('Notes was not updated.');
                console.log(data);
            }
        })
    });

    $('.deleteAppoint').on('click', function () {
        const id = $(this).attr('id');

        const url = '/delete_appointment/' + id;
        $.ajax({
            url    : url,
            type   : 'get',
            //data   : {'id': id},
            success: function (data) {
                //console.log(data);
                $('#row' + id).removeClass('hide-msg');
                $('#msg'+ id).html('Record has been marked for deletion.');
            },
            error  : function (data) {
                console.log('Record was not deleted.');
                console.log(data);
            }
        })

    })

</script>