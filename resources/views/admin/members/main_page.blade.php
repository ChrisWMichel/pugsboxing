@extends('layouts.admin_layout')


@section('content')


        <div class="well well-lg">
            <div class="row">
                <div class="col-sm-4">
                    <h4><span class="blue-title">{{$activeMembers}}</span>: Active Members</h4>
                    <h4><span class="blue-title">{{$personalsCount}}</span>: Personal Packages</h4>
                    <h4><span class="blue-title">{{$boxingClubCount}}</span>: Boxing Club</h4>
                </div>
                <div class="col-sm-4">
                    <h4><span class="blue-title">{{$sparringCount}}</span>: Sparring</h4>
                    <h4><span class="orange-title">{{$membershipDue}}</span>: Membership Due</h4>
                    <h4><span class="red-title">{{$membershipExpired}}</span>: Membership Expired</h4>
                </div>
                <div class="col-sm-4">
                    <h4><span class="red-title">{{$boxingClubExpired}}</span>: Boxing Club Expired</h4>
                        <h4>
                            <span class="blue-title">{{$archived}}</span>: Archived
                            <button type="button" class="btn btn-primary btn-sm getArchive" data-toggle="modal" data-target="#getArchive">View Archive</button>
                        </h4>
                </div>
            </div>

        </div>


<div class="col-md-4">
    <div class="well well-lg member-list">
        <div id="mem-list">
        <div class="btn-group-vertical center-block nav" role="group" aria-label="...">
            @foreach($members as $member)
                <?php
                    $now = \Carbon\Carbon::now();
                    $start = \Carbon\Carbon::parse($member->startMember);
                    $end = \Carbon\Carbon::parse($member->endMember);
                    $diffDays = $start->diffInDays($end);
                ?>
            @if(($diffDays <= 30) && ($now < $end))
                        <button type="button" id="{{$member->id}}" class="btn btn-lg btn-warning member-select">{{$member->firstname}} {{$member->lastname}}</button>

            @elseif(($now > $end)|| ($end->toDateString() == $now->toDateString()))
                        <button type="button" id="{{$member->id}}" class="btn btn-lg btn-danger member-select">{{$member->firstname}} {{$member->lastname}}</button>
            @else
                <button type="button" id="{{$member->id}}" class="btn btn-lg btn-success member-select">{{$member->firstname}} {{$member->lastname}}</button>
            @endif

            @endforeach
        </div>
        </div>
    </div>
</div>

    <div class="col-md-8 pull-right" >
        <div class="view-profile">
            <h3>Select a member on the right to view profile</h3>
        </div>

    </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="getArchive">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        <h4 class="modal-title">Archives</h4>
                    </div>
                    <div class="modal-body">

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date End</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($getArchive as $archive)
                                <tr>
                                    <td>{{$archive->firstname}}</td>
                                    <td>{{$archive->lastname}}</td>
                                    <td>{{$archive->email}}</td>
                                    <td>{{$archive->phone}}</td>
                                    <td>{{$archive->endMember}}</td>
                                    <td><button id="{{$archive->id}}" class="btn btn-warning btn-sm reactivate" onclick="reactivateMember(this)">Reactivate</button> </td>
                                    <td><a href="#" id="{{$archive->id}}" class="delete-member" onclick="deleteMember(this)">Delete</a> </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


@endsection

@section('scripts')
<script>
    let divMemList = document.getElementById('mem-list');
    divMemList.scrollTop = divMemList.scrollHeight;

    $('.member-select').click(function(){
        const member_id = $(this).attr('id');
        $(this).parents('.nav').find('button').addClass('btn-success'); //.end().end().removeClass('btn-success')
        $(this).removeClass('btn-success');

        const url = '/members/' + member_id;
        $.ajax({
            url    : url,
            type   : 'get',
            data   : {'id' : member_id},
            success: function (data) {
               $('.view-profile').html(data);
            },
            error  : function (data) {
                console.log('Profile ajax request.');
                console.log(data);
            }
        })
    });

    function reactivateMember(button){
        const mem_id = $(button).attr('id');

        //console.log('member id: ' + mem_id);
        const url = '/reactivate_member';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : {'id' : mem_id},
            success: function () {
               // console.log('member has been reactivated');
                $(button).removeClass('btn-warning');
                $(button).addClass('btn-success');
                $(button).text('Active') ;

            },
            error  : function (data) {
                console.log('Member was not reactivated.');
                console.log(data);
            }
        })
    }

    function deleteMember(link){
        const mem_id = $(link).attr('id');

        const url = '/delete_member';
        $.ajax({
            url    : url,
            type   : 'get',
            data   : {'id' : mem_id},
            success: function () {
                // console.log('member has been reactivated');
                $(link).text('Member has been marked for deletion.');
                $(link).css({'pointer-events' : 'none'});
                $(link).css({'text-decoration' : 'none'});

            },
            error  : function (data) {
                console.log('Member was not reactivated.');
                console.log(data);
            }
        })
    }
</script>
@endsection