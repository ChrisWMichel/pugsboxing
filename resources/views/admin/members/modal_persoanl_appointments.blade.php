<div class="modal fade" tabindex="-1" role="dialog" id="secheduleLog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sechedule Log For {{$member->firstname}} {{$member->lastname}}</h4>
            </div>
            <div class="modal-body modal-lg">
                @if(!empty($appointments))

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Appointment</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $appointment)

                                <tr>
                                    <td>{{\Carbon\Carbon::parse($appointment->start)->format('m/d/Y, g:i a') }}</td>
                                    <td>{{$appointment->title}}</td>
                                    <td><input type="text" id="note{{$appointment->id}}" value="{{$appointment->notes}}"></td>
                                    <td><button type="button" class="btn btn-primary btn-sm updateAppoint " id="{{$appointment->id}}">Update</button></td>
                                    <td><button type="button" class="btn btn-sm btn-danger deleteAppoint " id="{{$appointment->id}}">X</button></td>
                                </tr>
                                <tr  class="hide-msg" id="row{{$appointment->id}}">
                                    <td align="center" colspan="3"><h4 class="blue-title" id="msg{{$appointment->id}}"></h4></td>
                                </tr>

                        @endforeach

                        </tbody>
                    </table>

                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->