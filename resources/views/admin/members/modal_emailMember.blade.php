<div class="modal fade" tabindex="-1" role="dialog" id="emailMember">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Email {{$member->firstname}} - {{$member->email}}</h4>
            </div>
            <div class="modal-body">
                <p class="subjectEmpty red-title"></p>
                <form method="post" action="#">
                    <input type="text" id="adminSubject" class="form-control" placeholder="Subject" required><br>
                    <textarea name="admin_message" class="admin_message" rows="12" cols="12" required>Hi {{$member->firstname}},</textarea><br>
                    <input type="button" id="{{$member->id}}" class="sendEmailMember" value="Send Email">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->