<div class="modal fade" tabindex="-1" role="dialog" id="editProfile">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Profile</h4>
            </div>
            <div id="profile-msg"></div>

            <div class="modal-body">

                <form method="post" action="#">
                    {{csrf_field()}}


                    <div class="form-group">
                        {!! Form::label('firstname2', 'First Name:') !!}
                        {!! Form::text('firstname2', null, []) !!}
                        &nbsp;

                        {!! Form::label('lastname2', 'Last Name:') !!}
                        {!! Form::text('lastname2', null, []) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('phone2', 'Phone Number:') !!}
                        {!! Form::text('phone2', null, ['class' => 'short-length', 'maxlength' => 12]) !!}
                        &nbsp;

                        {!! Form::label('emergency_phone2', 'Emergency Phone:') !!}
                        {!! Form::text('emergency_phone2', null, ['class' => 'short-length', 'maxlength' => 12]) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('email2', 'Email:') !!}<br>
                        {!! Form::text('email2', null, ['class' => 'input-length']) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('street2', 'Address:') !!}<br>
                        {!! Form::text('street2', null, ['class' => 'input-length']) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('city2', 'City:') !!}
                        {!! Form::text('city2', null, []) !!}
                        &nbsp;

                        {!! Form::label('state2', 'State:') !!}
                        {!! Form::text('state2', null, ['class'=> 'state-member', 'maxlength' => 2]) !!}
                        &nbsp;

                        {!! Form::label('zipcode2', 'Zipcode:') !!}
                        {!! Form::text('zipcode2', null, ['class' => 'short-length']) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('DOB2', 'DOB:') !!}
                        {!! Form::text('DOB2', null, ['id' => 'dob2' ]) !!}

                    </div>

                    <div class="form-group">
                        {!! Form::label('startMember2', 'Membership Start:') !!}
                        {!! Form::text('startMember2', null, ['id' => 'newStartDate']) !!}
                        &nbsp;

                        {!! Form::label('endMember2', 'End:') !!}
                        {!! Form::text('endMember2', null, ['id' => 'endDate2']) !!}

                    </div>

                <hr>

                <button type="button" class="btn btn-primary updateBtn pull-right" id="{{$member->id}}">Update</button>&nbsp;
                    <button type="button" class="btn btn-default pull-right clearfix" data-dismiss="modal">Cancel</button>
            </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->